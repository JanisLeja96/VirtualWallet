<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class WalletTest extends TestCase
{
    public function testWalletCanBeCreated()
    {
        $wallet = Wallet::factory()->create();
        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    public function testWalletOwnerCanBeReturned()
    {
        $wallet = Wallet::factory()->create();
        $this->assertInstanceOf(User::class, $wallet->user);
    }
}
