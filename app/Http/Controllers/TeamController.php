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
        // No need to show root
        $people = User::where('id', '!=', 1);

        // if current user is sub-company, no need to show sub-companies.
        if (auth()->user()->id > 1) {
            $people = $people->where('id', '>', 3);
        }

        $people = $people->paginate(20);

        $nets = Entry::where('owner_id', null)->get();

        return view('team_index', [
            'people' => $people,
            'nets' => $nets,
            'isAcceptable' => PeopleUtil::isAcceptable()
        ]);
    }

    public function netIndex(Request $request, User $user=null)
    {
        if ($user == null) {
            $user = auth()->user();
        }

        $showMember = $request->get('showMember', false);

        $net = PeopleUtil::getNet($user);

        return view('team_net', [
            'net' => $net,
            'showMember' => $showMember
        ]);
    }
}
