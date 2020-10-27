<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function index()
    {
        return view('wallets.index', ['wallets' => Wallet::all()]);
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'balance' => ['required', 'numeric']
        ]);

        $wallet = new Wallet();
        $wallet->name = request('name');
        $wallet->balance = request('balance');
        $wallet->user_id = request('user_id');
        $wallet->save();

        return redirect('/wallets');
    }


}
