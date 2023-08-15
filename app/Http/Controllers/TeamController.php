<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use App\Utils\PeopleUtil;
use App\Utils\UserUtil;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class TeamController extends Controller
{
    public function home ()
    {
        return view('team_home');
    }
    //
    public function index(Request $request)
    {
        if (!UserUtil::isAdminOrCompany()) {
            return redirect()->back();
        }

        $company_id = $request->get('company_id');

        // No need to show root
        $people = User::where('id', '!=', 1);

        // if current user is sub-company, should show only set as verifier.
        if (UserUtil::isCompany()) {
            $people = $people->where('verifier_id', auth()->user()->id);
        } else if (UserUtil::isAdmin() && $company_id) {
            $people = $people->where('verifier_id', $company_id);
        }

        $people = $people->orderBy('id', 'desc');

        $people = $people->paginate(20);

        $people->appends(request()->query());

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
