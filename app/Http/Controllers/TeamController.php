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

        // if current user is sub-company, should show only set as verifier.
        if (auth()->user()->id > 1) {
            $people = $people->where('verifier_id', auth()->user()->id);
        }

        $people = $people->orderBy('id', 'desc');

        $people = $people->paginate(20);

        $nets = Entry::where('owner_id', null)->get();

        $subCompanies = PeopleUtil::getSubCompanies();

        return view('team_index', [
            'people' => $people,
            'nets' => $nets,
            'isAcceptable' => PeopleUtil::isAcceptable(),
            'subCompanies' => $subCompanies
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
