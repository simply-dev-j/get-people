<?php

namespace App\Http\Controllers;

use App\LocaleConstants;
use App\Models\Entry;
use App\Models\InviteCode;
use App\Models\User;
use App\Utils\PeopleUtil;
use App\Utils\TransactionUtil;
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
        return view('home', ['showBackButton' => false]);
    }

    public function money_index()
    {
        return view('home_money');
    }

    /**
     * Get all codes of current user
     */
    public function codeIndex(Request $request)
    {
        $people = auth()->user()->people()->orderBy('id', 'desc')->paginate(20);
        $nets = Entry::where('owner_id', null)->get();
        $subCompanies = PeopleUtil::getSubCompanies();

        return view('home_code', [
            'people' => $people,
            'nets' => $nets,
            'subCompanies' => $subCompanies
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

    /**
     * Delete code
     */
    public function deleteCode(Request $request, InviteCode $code)
    {
        $code->delete();

        flash(__(LocaleConstants::MESSAGE_BASE.LocaleConstants::MESSAGE_CODE_DELETED))->success();

        return redirect()->back();
    }

    public function transactionIndex(Request $request, $type)
    {
        $query = auth()->user()->transactions();

        $needToFundTransferPermission = auth()->user()->id > 3 && auth()->user()->fund_transfer_status != 2;

        $query = $query->where('type', $type);

        $query = $query->orderBy('id', 'desc');

        $transactions = $query->paginate(20);

        return view('home_transaction', [
            'transactions' => $transactions,
            'type' => $type,
            'needToFundTransferPermission' => $needToFundTransferPermission
        ]);
    }
}
