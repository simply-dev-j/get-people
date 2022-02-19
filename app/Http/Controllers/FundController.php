<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\ConfigUtil;
use App\Utils\PeopleUtil;
use App\Utils\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FundController extends Controller
{
    //
    public function conversionIndex()
    {
        $needToFundTransferPermission = auth()->user()->id > 3 && auth()->user()->fund_transfer_status != 2;
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
                // released_from_pending to release
                auth()->user()->released_from_pending -= $amount;
                auth()->user()->released += number_format($amount * 0.8, 2);
                auth()->user()->save();

                TransactionUtil::CRETE_TRANSACTION(
                    auth()->user(),
                    TransactionUtil::TRANSACTION_MONEY_RELEASE_FROM_PENDING_TO_RELEASE,
                    $amount
                );
                break;
            case 2:
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

        flash('转账成功', 'success');

        return redirect()->back()->withInput();
    }

    public function conversionApprovalRequest(Request $request)
    {
        $user = auth()->user();
        $currentStatus = auth()->user()->fund_transfer_status;

        if ($user->released_from_pending < ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST()) {
            flash('您的购车积分小于'.ConfigUtil::AMOUNT_OF_ACCEPT_FUND_TRANSFER_REQUEST().'无法申请', 'danger');
            return redirect()->back();
        }

        if ($currentStatus == 0) {
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
        $requests = User::whereIn('fund_transfer_status', [1, 2])->orderBy('id', 'desc')->paginate(20);
        return view('fund_conversion_request', compact('requests'));
    }

    public function conversionRequestApprove(Request $request, User $user)
    {
        PeopleUtil::onAcceptFundTransferRequest($user);

        $user->update([
            'fund_transfer_status' => 2
        ]);

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

        $receiver = User::where('name', $validated['transfer_receiver'])->whereIn('id', [2, 3])->first();

        // if not exist
        // if($receiver == null) {
        //     flash('收款人不存在', 'danger');
        //     return redirect()->back()->withInput();
        // }

        // if receiver is not a sub-company
        if ($receiver == null) {
            flash('注册积分只能由个人转给分公司', 'danger');
            return redirect()->back()->withInput();
        }

        // securify code is wrong
        if(auth()->user()->security_code != $validated['security_code']) {
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $amount = $validated['transfer_amount'];

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

        // securify code is wrong
        if(auth()->user()->security_code != $all['security_code']) {
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        if ($fundType == TransactionUtil::TYPE_WITHDRAWN) {
            $company->increment('withdrawn', $amount);

            TransactionUtil::CRETE_TRANSACTION(
                $company,
                TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN,
                $amount,
                auth()->user()
            );
        } else if ($fundType == TransactionUtil::TYPE_RELEASE) {
            $company->increment('released', $amount);

            TransactionUtil::CRETE_TRANSACTION(
                $company,
                TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_RELEASED,
                $amount,
                auth()->user()
            );
        } else if ($fundType == TransactionUtil::TYPE_RELEASED_FROM_PENDING) {
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

        // securify code is wrong
        if(auth()->user()->security_code != $all['security_code']) {
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $member->decrement('withdrawn', $amount);
        auth()->user()->increment('withdrawn', $amount);

        TransactionUtil::CRETE_TRANSACTION(
            $member,
            TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN,
            -$amount,
            auth()->user()
        );

        TransactionUtil::CRETE_TRANSACTION(
            auth()->user(),
            TransactionUtil::TRANSACTION_MONEY_ADJUST_BY_ROOT_WITHDRAWN,
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

        // securify code is wrong
        if(auth()->user()->security_code != $all['security_code']) {
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $company = User::find($all['company_id']);
        $amount = $all['transfer_amount'];

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
