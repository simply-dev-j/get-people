<?php

namespace App\Http\Controllers;

use App\LocaleConstants;
use App\Models\InviteCode;
use App\Utils\PeopleUtil;
use App\WebRoute;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthController extends Controller
{
    //

    public function __construct()
    {

    }

    /**
     * Show login form
     */
    public function login(Request $request)
    {
        return view('auth.login');
    }

    /**
     * Handle of login action
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'password' => 'required|min:1|max:255'
        ]);

        $credentials = $request->only('name', 'password');

        Auth::logout();

        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        } else {
            flash(__(LocaleConstants::AUTH_BASE.LocaleConstants::AUTH_FAIL))->error();
            return redirect()->back()->withInput();
        }

    }

    /**
     * Show registration form
     */
    public function register(Request $request)
    {
        return view('auth.register');
    }

    /**
     * Handle of registration action
     */
    public function registerPost(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required',
            'name' => 'required|min:3|max:255|unique:users,name',
            'security_code' => 'required',
            // 'email' => 'required|email|min:3|max:255|unique:users,email',
            'password' => 'required|max:255|same:confirm_password',
            'username' => 'required|max:255',
            'phone' => 'nullable',
            'id_number' => 'required|max:255'
        ]);

        // check if code is already used
        $inviteCode = InviteCode::where('code', $validated['code'])->where('accepted', false)->first();

        if($inviteCode == null) {
            flash(__(LocaleConstants::AUTH_BASE.LocaleConstants::AUTH_INVALID_CODE))->error();
            return redirect()->back()->withInput();
        }

        // everything is okay. let's create new user.
        $inviteCode->update(['accepted' => true]);

        $validated = array_merge($validated, [
            'password' => Hash::make($validated['password'])
        ]);

        $user = $inviteCode->owner->people()->create($validated);

        $inviteCode->user()->save($user);

        /*
            TODO: Need to add actions of people invitation.

            1. Need to check if owner's cell is filled or not.
            2. Determine the stage of new user and transformation of owner's stage.
            3. Calculation of money; pending and release
        */
        // PeopleUtil::updateEntry($user);

        return redirect(route(WebRoute::AUTH_LOGIN))->withInput();
    }

    public function logout()
    {
        try {
            auth()->logout();
        } catch (Exception $e) {

        }

        return redirect(route(WebRoute::AUTH_LOGIN));
    }

    public function home()
    {
        return view('auth_home');
    }

    public function profile(Request $request)
    {
        return view('auth_profile');
    }

    public function profilePost(Request $request)
    {
        $validated = $request->validate([
            'id_number' => 'nullable'
        ]);

        auth()->user()->update($validated);

        return redirect()->back()->withInput();
    }

    public function bank()
    {
        return view('auth_bank');
    }

    public function bankPost(Request $request)
    {
        $validated = $request->validate([
            'bank' => 'required',
            'bank_number' => 'nullable',
            'bank_address' => 'nullable'
        ]);

        auth()->user()->update($validated);

        flash('银行信息更新成功', 'success');

        return redirect()->back()->withInput();
    }

    public function resetPassword()
    {
        return view('auth_reset_password');
    }

    public function resetPasswordPost(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'password' => 'required|same:confirm_password'
        ]);

        if(!Hash::check($validated['old_password'], auth()->user()->password)) {
            flash('错误密码', 'danger');
            return redirect()->back();
        }

        auth()->user()->update([
            'password' => Hash::make($request['password'])
        ]);

        flash('密码已更新', 'success');
        return redirect()->back();
    }

    public function phone()
    {
        return view('auth_phone');
    }
}
