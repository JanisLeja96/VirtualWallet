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

    public function getBalanceAttribute($value)
    {
        return number_format($value, 2);
    }

    public function deductFromBalance(float $amount)
    {
        $this->attributes['balance'] -= $amount;
    }
}
