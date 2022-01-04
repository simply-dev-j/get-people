<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\PeopleUtil;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function userIndex()
    {
        $people = User::whereNotIn('id', [1])->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.user', ['people' => $people]);
    }

    public function userActivate(Request $request, User $user)
    {
        $user->update([
            'active' => true
        ]);

        PeopleUtil::updateEntry($user);

        return redirect()->back()->withInput();
    }

    public function userInactivate(Request $request, User $user)
    {
        $user->update([
            'active' => false
        ]);

        return redirect()->back()->withInput();
    }
}
