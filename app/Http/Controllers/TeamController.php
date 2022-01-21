<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use App\Utils\PeopleUtil;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    //
    public function index()
    {
        $people = User::where('id', '!=', auth()->user()->id)->paginate(20);

        $nets = Entry::where('owner_id', null)->get();
        return view('team_index', [
            'people' => $people,
            'nets' => $nets
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
