<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function index()
    {
        return view('wallets', ['wallets' => Wallet::all()]);
    }


}
