<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{

    public function index()
    {
        return view('wallets.index', ['wallets' => Wallet::where('user_id', Auth::user()['id'])->get()]);
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

    public function show(Wallet $wallet)
    {
        return view('wallets.show', ['wallet' => $wallet]);
    }


}
