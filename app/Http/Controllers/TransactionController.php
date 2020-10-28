<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create(Wallet $wallet)
    {
        return view('transactions.create', ['wallet' => $wallet]);
    }

    public function store(Wallet $wallet)
    {
        request()->validate([
            'amount' => ['required', 'numeric'],
            'description' => 'required',
            'recipient_wallet_id' => 'required'
        ]);
        try {
            $recipientWallet = Wallet::findOrFail(request('recipient_wallet_id'));
        } catch (ModelNotFoundException $exception) {
            return back()->withError('Wallet not found')->withInput();
        }

        if ($wallet->balance < request('amount')) {
            return back()->withError('Insufficient funds')->withInput();
        }


        $transaction = new Transaction();
        $transaction->amount = request('amount');
        $transaction->description = request('description');
        $transaction->recipient_wallet_id = request('recipient_wallet_id');
        $transaction->recipient_id = User::find($recipientWallet->user_id)->id;
        $transaction->sender_wallet_id = request('sender_wallet_id');
        $transaction->sender_id = Wallet::find($wallet->id)->id;
        $transaction->save();

        $wallet->update(['balance' => $wallet->balance - request('amount')]);
        $recipientWallet->update(['balance' => $recipientWallet->balance + request('amount')]);


        return redirect($wallet->path());
    }
}
