<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function path()
    {
        return route('showWallet', $this);
    }

    public function outgoingTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_wallet_id')->orderByDesc('created_at');
    }

    public function incomingTransactions()
    {
        return $this->hasMany(Transaction::class, 'recipient_wallet_id')->orderByDesc('created_at');
    }

}
