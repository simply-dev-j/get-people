<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\PeopleUtil;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    //
    public function index()
    {
        $people = auth()->user()->people()->where('active', true)->paginate(20);

        return view('team_index', [
            'people' => $people
        ]);
    }

    public function netIndex(Request $request, User $user=null)
    {
        if ($user == null) {
            $user = auth()->user();
        }

        $net = PeopleUtil::getNet($user);

        return view('team_net', [
            'net' => $net
        ]);
    }
}
