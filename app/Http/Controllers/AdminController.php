<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use App\Utils\PeopleUtil;
use Illuminate\Http\Request;
use Hash;

class AdminController extends Controller
{
    //
    public function userIndex()
    {
        $people = User::whereNotIn('id', [1])->orderBy('created_at', 'desc')->paginate(20);

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
            // 'id_number' => 'required|max:255'
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

        $user = User::findOrFail($validated['user']);

        if ($user->security_code != $validated['security_code']) {

            flash('错误安全码', 'danger');

        } else {

            $user->update([
                'active' => true
            ]);

            PeopleUtil::updateEntry($user);

            flash('用户激活成功', 'success');
        }

        return redirect()->back()->withInput();
    }

    public function userActivateInSpecNet(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required',
            'selected_net' => 'required'
        ]);

        $user = User::findOrFail($validated['user']);
        $entry = Entry::findOrFail($validated['selected_net']);

        $user->update([
            'active' => true
        ]);

        PeopleUtil::updateEntry($user, $entry);

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
}
