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
        $outgoing = $wallet->outgoingTransactions->toArray();
        foreach ($outgoing as &$transaction) {
            $transaction['type'] = 'Outgoing';
        }
        $incoming = $wallet->incomingTransactions->toArray();

        foreach ($incoming as &$transaction) {
            $transaction['type'] = 'Incoming';
        }

        $transactions = [...$outgoing, ...$incoming];

        $transactions = array_filter($transactions, function($transaction) use ($wallet) {
            return !in_array($wallet->id, str_split($transaction['hidden_for']));
        });

        $outgoing = array_filter($transactions, function($transaction) {
            return $transaction['type'] == 'Outgoing';
        });

        $incoming = array_filter($transactions, function($transaction) {
            return $transaction['type'] == 'Incoming';
        });


        usort($transactions, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('wallets.show', [
            'wallet' => $wallet,
            'transactions' => $transactions,
            'outgoingSum' => number_format(array_sum(array_column($outgoing, 'amount')), 2),
            'incomingSum' => number_format(array_sum(array_column($incoming, 'amount')), 2)
        ]);
    }

    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return redirect('/wallets');
    }

    public function edit(Wallet $wallet)
    {
        return view('wallets.edit', ['wallet' => $wallet]);
    }

    public function update(Wallet $wallet)
    {
        request()->validate([
            'name' => 'required',
        ]);

        $wallet->update([
            'name' => request('name'),
        ]);

        return redirect($wallet->path());
    }


}
