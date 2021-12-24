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

        /*
            TODO: Need to add actions of people invitation.

            1. Need to check if owner's cell is filled or not.
            2. Determine the stage of new user and transformation of owner's stage.
            3. Calculation of money; pending and release
        */
        PeopleUtil::updateEntry($user);

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
}
