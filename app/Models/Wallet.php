<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function path()
    {
        return route('showWallet', $this);
    }

    public function getVisibleTransactions()
    {
        return $this->incomingTransactions
            ->merge($this->outgoingTransactions)
            ->reject(function($transaction) {
                return mb_strpos($transaction->hidden_for, " $this->id ") !== false;
            })
            ->sortByDesc('created_at');
    }

    public function outgoingTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_wallet_id')->orderByDesc('created_at');
    }

    public function incomingTransactions()
    {
        return $this->hasMany(Transaction::class, 'recipient_wallet_id')->orderByDesc('created_at');
    }

    public function getIncomingTransactionsSumAttribute()
    {
        return number_format($this->incomingTransactions
            ->reject(function($transaction) {
                return mb_strpos($transaction->hidden_for, " $this->id ") !== false;
            })
            ->sum('amount'), 2, '.', ',');
    }

    public function getOutgoingTransactionsSumAttribute()
    {
        return number_format($this->outgoingTransactions
            ->reject(function($transaction) {
                return mb_strpos($transaction->hidden_for, " $this->id ") !== false;
            })
            ->sum('amount'), 2, '.', ',');
    }

    public function getFormattedBalance()
    {
        return number_format($this->balance, 2, '.', ',');
    }

}
