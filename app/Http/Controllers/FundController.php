<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FundController extends Controller
{
    //
    public function conversionIndex()
    {
        return view('fund_conversion');
    }

    public function conversionPost(Request $request)
    {
        $validated = $request->validate([
            'conversion_method' => 'required',
            'conversion_amount' => 'required|numeric'
        ]);

        auth()->user()->released -= $request['conversion_amount'];
        auth()->user()->withdrawn += number_format($request['conversion_amount'] * 0.8, 2);
        auth()->user()->save();

        flash('转账成功', 'success');

        return redirect()->back()->withInput();
    }

    public function transferIndex()
    {
        return view('fund_transfer');
    }

    public function transferPost(Request $request)
    {
        $validated = $request->validate([
            'transfer_receiver' => 'required',
            'transfer_amount' => 'required',
            'security_code' => 'required'
        ]);

        $receiver = User::where('name', $validated['transfer_receiver'])->first();
        // if not exist
        if($receiver == null) {
            flash('收款人不存在', 'danger');
            return redirect()->back()->withInput();
        }

        // securify code is wrong
        if(auth()->user()->security_code != $validated['security_code']) {
            flash('错误安全码', 'danger');
            return redirect()->back()->withInput();
        }

        $receiver->increment('released', $validated['transfer_amount']);
        auth()->user()->decrement('released', $validated['transfer_amount']);

        flash('转移成功', 'success');
        return redirect()->back();
    }

    public function withdraw()
    {
        return view('fund_withdraw');
    }
}
