<?php

namespace App\Http\Controllers;

use App\LocaleConstants;
use App\Models\Entry;
use App\Models\User;
use App\Utils\PeopleUtil;
use App\Utils\SecurityUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Hash;

class AdminController extends Controller
{
    //
    public function userIndex()
    {
        $people = User::whereNotIn('id', [1])->paginate(20);

        $nets = Entry::where('owner_id', null)->get();

        return view('admin.user', ['people' => $people, 'nets' => $nets]);
    }

    public function userCreate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:users,name',
            'security_code' => 'required',
            // 'email' => 'required|email|min:3|max:255|unique:users,email',
            'password' => 'required|max:255|same:confirm_password',
            'username' => 'required|max:255',
            'phone' => 'nullable',
            'id_number' => 'required|max:255',
            'verifier_id' => 'nullable'
        ]);

        $validated = array_merge($validated, [
            'password' => Hash::make($validated['password'])
        ]);

        $user = auth()->user()->people()->create($validated);

        flash('用户注册成功', 'success');

        return redirect()->back();
    }

    public function userActivate(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required',
            'security_code' => 'required'
        ]);

        // securify challeng
        if (!SecurityUtil::SECURITY_CHALLENGE(SecurityUtil::SECURITY_CASE_USER_ACTIVATION, $validated['security_code'])){
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $user = User::findOrFail($validated['user']);

        if ($user->active) {
            flash(__(LocaleConstants::MESSAGE_BASE.LocaleConstants::MESSAGE_USER_ACTIVE_ALREADY), 'warning');
        }

        if (PeopleUtil::isAcceptable()) {

            $user->update([
                'active' => true,
                'verifier_id' => auth()->user()->id
            ]);

            PeopleUtil::updateEntry($user);

            PeopleUtil::onAccept($user);

            flash('用户激活成功', 'success');
        } else {
            flash('注册积分不足', 'danger');
        }

        return redirect()->back()->withInput();
    }

    public function userActivateInSpecNet(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required',
            'selected_net' => 'required',
            'security_code' => 'required'
        ]);

        // securify challeng
        if (!SecurityUtil::SECURITY_CHALLENGE(SecurityUtil::SECURITY_CASE_USER_ACTIVATION, $validated['security_code'])){
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $user = User::findOrFail($validated['user']);
        $entry = Entry::findOrFail($validated['selected_net']);

        if ($user->active) {
            flash(__(LocaleConstants::MESSAGE_BASE.LocaleConstants::MESSAGE_USER_ACTIVE_ALREADY), 'warning');
        }

        if (PeopleUtil::isAcceptable()) {

            $user->update([
                'active' => true,
                'verifier_id' => auth()->user()->id
            ]);

            PeopleUtil::updateEntry($user, $entry);

            PeopleUtil::onAccept($user);

            flash('用户激活成功', 'success');
        } else {
            flash('注册积分不足', 'danger');
        }

        return redirect()->back()->withInput();
    }

    public function userInactivate(Request $request, User $user)
    {
        $user->update([
            'active' => false
        ]);

        return redirect()->back()->withInput();
    }

    public function userDelete(Request $request, User $user)
    {
        $invite_code = $user->invite_code;

        if ($invite_code) {
            $invite_code->update([
                'accepted' => false
            ]);
        }

        $user->delete();

        return redirect()->back()->withInput();
    }

    public function validateName(Request $request)
    {
        $name = $request->get('name');

        $user = User::where('name', $name)->first();

        if ($user == null)
            return "true";
        else
            return "false";
    }

    public function companyIndex(Request $request)
    {
        $companies = User::where('is_company', true)
            ->where('active', true)
            ->orderBy('id', 'desc')
            ->paginate(20);

        $users = User::where('is_company', false)
            ->where('active', true)
            ->where('is_admin', false)
            ->get();

        return view('admin.company', [
            'companies' => $companies,
            'users' => $users
        ]);
    }

    public function companyPost(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'security_code' => 'required'
        ]);

        // security challenge
        if (!SecurityUtil::SECURITY_CHALLENGE(SecurityUtil::SECURITY_CASE_COMPANY_PROMOTION, $validated['security_code'])){
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $userId = $validated['user_id'];

        $user = User::findOrFail($userId);

        $user->update([
            'is_company' => true,
            'company_req_date' => Carbon::now(),
            'fund_transfer_status' => 2
        ]);

        flash(__(LocaleConstants::MESSAGE_BASE.LocaleConstants::MESSAGE_COMPANY_ADD_SUCCESS), 'success');

        return redirect()->back();
    }
}
