<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaction;
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

    public function store(StoreTransaction $request, Wallet $wallet)
    {
        $validated = $request->validated();

        try {
            $recipientWallet = Wallet::findOrFail(request('recipient_wallet_id'));
        } catch (ModelNotFoundException $exception) {
            return back()->withError('Wallet not found')->withInput();
        }

        if ($wallet->balance < (float) request('amount')) {
            return back()->withError('Insufficient funds')->withInput();
        } else if ($recipientWallet->id == $wallet->id) {
            return back()->withError('Invalid wallet ID entered')->withInput();
        }


        $transaction = new Transaction();
        $transaction->fill($validated);
        $transaction->recipient_id = User::find($recipientWallet->user_id)->id;
        $transaction->sender_id = $wallet->user->id;
        $transaction->save();

        $wallet->update(['balance' => $wallet->balance - request('amount')]);
        $recipientWallet->update(['balance' => $recipientWallet->balance + request('amount')]);

        return redirect($wallet->path());
    }

    public function hide(Wallet $wallet, Transaction $transaction)
    {
        $transaction->hidden_for .= " {$wallet->id} ";
        $transaction->save();
        return redirect($wallet->path());
    }

    public function mark(Wallet $wallet, Transaction $transaction)
    {
        if ($transaction->fraudulent == 0 || $transaction->marked_by == $wallet->user->id) {
            if ($transaction->fraudulent == 1) {
                $transaction->fraudulent = 0;
            } else {
                $transaction->fraudulent = 1;
                $transaction->marked_by = $wallet->user->id;
            }
            $transaction->save();
            return redirect($wallet->path());
        }

        return redirect($wallet->path())->withError('Only user who marked transaction can unmark it')->withInput();
    }
}
