<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateWallet()
    {
        $user = User::factory()->create(['id' => 1]);

        $this->actingAs($user)->post('/wallets/store', [
            'name' => 'testWallet',
            'balance' => 100,
            'user_id' => 1
        ]);

        $this->assertEquals('testWallet', Wallet::first()->name);
    }

    public function testUserCanOpenWallet()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'name' => 'testWallet',
            'user_id' => 1,
            'id' => 1
        ]);

        $this->actingAs($user)->get('/wallets/1')->assertSee('Wallet name');
    }

    public function testUserCanRenameWallet()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1
        ]);

        $this->actingAs($user)->put('/wallets/1/edit', ['name' => 'renamed'])->assertSee('renamed');
    }

    public function testUserCanDeleteWallet()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1
        ]);

        $this->actingAs($user)->delete('/wallets/1');
        $this->expectException(ModelNotFoundException::class);
        Wallet::findOrFail(1);
    }
}
