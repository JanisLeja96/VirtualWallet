<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function senderWallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function recipientWallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function getSenderNameAttribute()
    {
        return $this->sender->fullname;
    }

    public function recipient()
    {
        return $this->belongsTo(User::class);
    }

    public function getRecipientNameAttribute()
    {
        return $this->recipient->fullname;
    }

    public function getTransactionType(Wallet $wallet)
    {
        return $wallet->id === $this->senderWallet->id ? 'Outgoing' : 'Incoming';
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('H:i d/M/Y');
    }

}
