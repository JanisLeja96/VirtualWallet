<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWallet;
use App\Http\Requests\UpdateWallet;
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

    public function store(StoreWallet $request)
    {
        $validated = $request->validated();

        $wallet = new Wallet();
        $wallet->fill($validated);
        $wallet->user_id = $validated['user_id'];
        $wallet->save();

        return redirect(route('wallets'));
    }

    public function show(Wallet $wallet)
    {
        return view('wallets.show', [
            'wallet' => $wallet,
        ]);
    }

    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return redirect(route('wallets'));
    }

    public function edit(Wallet $wallet)
    {
        return view('wallets.edit', ['wallet' => $wallet]);
    }

    public function update(UpdateWallet $request, Wallet $wallet)
    {
        $validated = $request->validated();
        $wallet->update($validated);

        return redirect($wallet->path());
    }


}
