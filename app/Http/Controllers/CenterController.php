<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\User;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    //

    public function index()
    {
        $allUsers = User::all();

        return view('center_index', ['allUsers' => $allUsers]);
    }

    public function register()
    {
        return view('center_registration');
    }

    public function registerPost(Request $request)
    {
        $validated = $request->validate([
            'center_name' => 'required',
            'center_address' => 'required'
        ]);

        $user = auth()->user();
        $user->center()->delete();
        $user->center()->create($validated);

        return redirect()->back()->withInput();
    }
}
