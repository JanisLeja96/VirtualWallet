<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanBeCreated()
    {
        $user = User::factory()->create(['username' => 'test']);
        User::factory()->create();

        $this->assertEquals('test', $user->username);
    }

    public function testUserWalletCanBeReturned()
    {
        $user = User::factory()->create(['id' => 1]);
        $wallet = Wallet::factory()->create(['user_id' => 1]);
        $this->assertInstanceOf(Wallet::class, $user->wallets->first());
    }
}
