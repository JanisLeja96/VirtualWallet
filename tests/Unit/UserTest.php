<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanBeCreated()
    {
        $user = User::factory()->create(['username' => 'test']);
        User::factory()->create();

        $this->assertEquals('test', $user->username);
    }

    public function testUserWalletCanBeReturned()
    {
        $user = User::find(1);
        $this->assertInstanceOf(Wallet::class, $user->wallets->first());
    }
}
