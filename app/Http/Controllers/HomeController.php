<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;

class HomeController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index()
    {
        return view('home');
    }

    /**
     * Get all codes of current user
     */
    public function codeIndex(Request $request)
    {
        $page = $request->get('page');

        $codes = auth()->user()->invite_codes()->orderBy('created_at', 'desc')->paginate('20');

        return view('code_index', [
            'codes' => $codes
        ]);
    }

    /**
     * Create new code of current user.
     */
    public function createCode(Request $request)
    {
        $user = auth()->user();

        $code = strtoupper(Str::random(10));

        $user->invite_codes()->create([
            'code' => $code
        ]);

        $request->session()->flash('code', $code);

        return redirect()->back();
    }
}
