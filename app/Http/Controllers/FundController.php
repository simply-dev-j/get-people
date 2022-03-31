<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\ConfigUtil;
use App\Utils\PeopleUtil;
use App\Utils\SecurityUtil;
use App\Utils\TransactionUtil;
use App\Utils\UserUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FundController extends Controller
{

    public function home()
    {
        return view('fund_home');
    }
    //
    public function conversionIndex()
    {
        $needToFundTransferPermission = !UserUtil::isAdminOrCompany() && auth()->user()->fund_transfer_status != 2;
        return view('fund_conversion', compact('needToFundTransferPermission'));
    }

    public function conversionPost(Request $request)
    {
        $validated = $request->validate([
            'conversion_method' => 'required',
            'conversion_amount' => 'required|numeric'
        ]);

        $amount = $request->get('conversion_amount');

        switch($validated['conversion_method']) {
            case 1:
                if (!TransactionUtil::VERIFY_WORTH(auth()->user(), TransactionUtil::TYPE_RELEASED_FROM_PENDING, $amount)) {
                    flash('无可用积分，不能转换', 'danger');
                    return redirect()->back();
                }

                // released_from_pending to release
                auth()->user()->released_from_pending -= $amount;
                auth()->user()->released += (int)($amount * 0.8);
                auth()->user()->save();

                TransactionUtil::CRETE_TRANSACTION(
                    auth()->user(),
                    TransactionUtil::TRANSACTION_MONEY_RELEASE_FROM_PENDING_TO_RELEASE,
                    $amount
                );
                break;
            case 2:
                if (!TransactionUtil::VERIFY_WORTH(auth()->user(), TransactionUtil::TYPE_RELEASE, $amount)) {
                    flash('无可用积分，不能转换', 'danger');
                    return redirect()->back();
                }
                // release to withdrawn
                auth()->user()->released -= $amount;
                auth()->user()->withdrawn += $amount;
                auth()->user()->save();

                TransactionUtil::CRETE_TRANSACTION(
                    auth()->user(),
                    TransactionUtil::TRANSACTION_MONEY_RELEASE_TO_WITHDRAWN,
                    $amount
                );
                break;
        }

        flash('资金转换成功', 'success');

        return redirect()->back()->withInput();
    }

    public function conversionApprovalRequest(Request $request)
    {
        $user = auth()->user();
        $currentStatus = auth()->user()->fund_transfer_status;

        if (!TransactionUtil::VERIFY_WORTH($user, TransactionUtil::TYPE_RELEASED_FROM_PENDING, ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST())) {
            flash('您的购车积分小于'.ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST().'无法申请', 'danger');
            return redirect()->back();
        }

        if ($currentStatus == 0) {
            PeopleUtil::onAcceptFundTransferRequest($user);

            auth()->user()->update([
                'fund_transfer_status' => 1,
                'fund_transfer_req_date' => Carbon::now()
            ]);

            flash('请等待分公司的同意', 'success');
        } else if($currentStatus == 1) {
            flash('审核中', 'danger');
        }

        return redirect()->back();

    }

    public function conversionRequestIndex(Request $request)
    {
        $requests = User::whereIn('fund_transfer_status', [1, 2])->orderBy('fund_transfer_req_date', 'desc')->paginate(20);
        return view('fund_conversion_request', compact('requests'));
    }

    public function conversionRequestApprove(Request $request, User $user)
    {
        if (!UserUtil::isAdminOrCompany($user)) {

            $user->update([
                'fund_transfer_status' => 2
            ]);

        }

        return redirect()->back();
    }

    public function transferIndex()
    {
        return view('fund_transfer');
    }

    public function transferPost(Request $request)
    {
        $validated = $request->validate([
            'transfer_receiver' => 'required',
            'transfer_amount' => 'required',
            'security_code' => 'required'
        ]);

        // securify challeng
        if (!SecurityUtil::SECURITY_CHALLENGE(SecurityUtil::SECURITY_CASE_FUND_TRANSFER, $validated['security_code'])){
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        // 분공사들 사이의 전송 차단.
        // 현재 사용자가 분공사인 경우 차단.
        if (UserUtil::isCompany()) {
            flash('分公司不能转积分', 'danger');
            return redirect()->back()->withInput();
        }

        $receiver = User::where('name', $validated['transfer_receiver'])->whereIn('id', [2, 3])->first();

        // if receiver is not a sub-company
        if ($receiver == null) {
            flash('注册积分只能由个人转给分公司', 'danger');
            return redirect()->back()->withInput();
        }

        $amount = $validated['transfer_amount'];

        if ( !TransactionUtil::VERIFY_WORTH(auth()->user(), TransactionUtil::TYPE_WITHDRAWN, $amount)) {
            flash('无可用积分，不能转换', 'danger');
            return redirect()->back();
        }

        $receiver->increment('withdrawn', $validated['transfer_amount']);
        auth()->user()->decrement('withdrawn', $validated['transfer_amount']);

        TransactionUtil::CRETE_TRANSACTION(
            auth()->user(),
            TransactionUtil::TRANSACTION_MONEY_WITHDRAWN_SEND,
            $amount,
            $receiver
        );

        TransactionUtil::CRETE_TRANSACTION(
            $receiver,
            TransactionUtil::TRANSACTION_MONEY_WITHDRAWN_RECEIVE,
            $amount,
            auth()->user()
        );


        flash('转账成功', 'success');
        return redirect()->back();
    }

    public function withdraw()
    {
        return view('fund_withdraw');
    }

    public function companyEdit() {
        $subCompanies = PeopleUtil::getSubCompanies();

        return view('fund_company_edit', [
            'subCompanies' => $subCompanies
        ]);
    }

    public function companyEditPost(Request $request) {
        $all = $request->all();

        $company = User::find($all['company_id']);
        $amount = $all['transfer_amount'];
        $fundType = $all['fund_type'];

        // securify challeng
        if (!SecurityUtil::SECURITY_CHALLENGE(SecurityUtil::SECURITY_CASE_FUND_COMPANY_EDIT, $all['security_code'])){
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        if ($fundType == TransactionUtil::TYPE_WITHDRAWN) {

            if ( !TransactionUtil::VERIFY_WORTH($company, TransactionUtil::TYPE_WITHDRAWN, -$amount)) {
                flash('无可用积分，不能转换', 'danger');
                return redirect()->back();
            }

            $company->increment('withdrawn', $amount);

            TransactionUtil::CRETE_TRANSACTION(
                $company,
                TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN,
                $amount,
                auth()->user()
            );
        } else if ($fundType == TransactionUtil::TYPE_RELEASE) {

            if ( !TransactionUtil::VERIFY_WORTH($company, TransactionUtil::TYPE_RELEASE, -$amount)) {
                flash('无可用积分，不能转换', 'danger');
                return redirect()->back();
            }

            $company->increment('released', $amount);

            TransactionUtil::CRETE_TRANSACTION(
                $company,
                TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED,
                $amount,
                auth()->user()
            );
        } else if ($fundType == TransactionUtil::TYPE_RELEASED_FROM_PENDING) {

            if ( !TransactionUtil::VERIFY_WORTH($company, TransactionUtil::TYPE_RELEASED_FROM_PENDING, -$amount)) {
                flash('无可用积分，不能转换', 'danger');
                return redirect()->back();
            }

            $company->increment('released_from_pending', $amount);

            TransactionUtil::CRETE_TRANSACTION(
                $company,
                TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED_FROM_PEDNING,
                $amount,
                auth()->user()
            );
        }

        flash('积分变更成功', 'success');
        return redirect()->back();

    }

    public function companyAdjust() {
        $subCompanies = PeopleUtil::getSubCompanies();

        $members = User::where('id', '!=',  1)->where('active', 1)->get();

        return view('fund_company_adjust', [
            'members' => $members
        ]);
    }

    public function companyAdjustPost(Request $request) {
        $all = $request->all();

        $member = User::find($all['member_id']);
        $amount = $all['transfer_amount'];
        $fund_type = $all['fund_type'];

        // securify challeng
        if (!SecurityUtil::SECURITY_CHALLENGE(SecurityUtil::SECURITY_CASE_FUND_COMPANY_ADJUST, $all['security_code'])){
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        if ( !TransactionUtil::VERIFY_WORTH($member, $fund_type, $amount)) {
            flash('无可用积分，不能转换', 'danger');
            return redirect()->back();
        }

        $moneyType = "";
        $transactionType = "";

        switch($fund_type) {
            case TransactionUtil::TYPE_WITHDRAWN:
                $moneyType = "withdrawn";
                $transactionType = TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN;
                break;
            case TransactionUtil::TYPE_RELEASE:
                $transactionType = TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED;
                $moneyType = "released";
                break;
            case TransactionUtil::TYPE_RELEASED_FROM_PENDING:
                $transactionType = TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED_FROM_PEDNING;
                $moneyType = "released_from_pending";
                break;
        }

        $member->decrement($moneyType, $amount);
        auth()->user()->increment($moneyType, $amount);

        TransactionUtil::CRETE_TRANSACTION(
            $member,
            $transactionType,
            -$amount,
            auth()->user()
        );

        TransactionUtil::CRETE_TRANSACTION(
            auth()->user(),
            $transactionType,
            $amount,
            $member
        );

        flash('转账成功', 'success');
        return redirect()->back();

    }

    public function companyTranfer(Request $request)
    {
        $subCompanies = PeopleUtil::getSubCompanies();

        return view('fund_company_transfer', [
            'subCompanies' => $subCompanies
        ]);
    }

    public function companyTranferPost(Request $request)
    {
        $all = $request->all();

        // securify challeng
        if (!SecurityUtil::SECURITY_CHALLENGE(SecurityUtil::SECURITY_CASE_FUND_COMPANY_TRANSFER, $all['security_code'])){
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $company = User::find($all['company_id']);
        $amount = $all['transfer_amount'];

        if ( !TransactionUtil::VERIFY_WORTH(auth()->user(), TransactionUtil::TYPE_WITHDRAWN, $amount)) {
            flash('无可用积分，不能转换', 'danger');
            return redirect()->back();
        }

        $company->increment('withdrawn', $amount);
        auth()->user()->decrement('withdrawn', $amount);

        TransactionUtil::CRETE_TRANSACTION(
            $company,
            TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN,
            +$amount,
            auth()->user()
        );

        TransactionUtil::CRETE_TRANSACTION(
            auth()->user(),
            TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN,
            -$amount,
            $company
        );

        flash('转账成功', 'success');
        return redirect()->back();
    }
}
