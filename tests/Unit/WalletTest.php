<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    public function testWalletCanBeCreated()
    {
        User::factory()->create(['id' => 1]);
        $wallet = Wallet::factory()->create();
        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    public function testWalletOwnerCanBeReturned()
    {
        User::factory()->create(['id' => 1]);
        $wallet = Wallet::factory()->create();
        $this->assertInstanceOf(User::class, $wallet->user);
    }
}
