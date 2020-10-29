<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WalletTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function testWalletCanBeCreated()
    {
        $user = User::factory()->create(['id' => 1]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/create')
                ->type('name', 'TestWallet')
                ->type('balance', 100)
                ->click('@create')
                ->assertPathIs('/wallets');
        });
    }

    public function testWalletCanBeOpened()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create(['user_id' => 1]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets')
                ->click('@showWallet')
                ->assertSee('Wallet name');
        });
    }

    public function testWalletCanBeRenamed()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->click('@rename')
                ->type('name', 'renamed')
                ->click('@update')
                ->assertSee('renamed');
        });
    }

    public function testEmptyFieldNotAllowedWhileRenaming()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->click('@rename')
                ->type('name', '')
                ->click('@update')
                ->assertPathIs('/wallets/1/edit');
        });
    }

    public function testWalletCanBeDeleted()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'toDelete'
        ]);

        $this->expectException(ModelNotFoundException::class);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->assertSee('toDelete')
                ->click('@delete');
        });

        Wallet::where('name', 'toDelete')->firstOrFail();
    }

    public function testUserCanLogOut()
    {
        $user = User::factory()->create(['id' => 1]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets')
                ->click('@logout')
                ->assertPathIs('/');
        });
    }

    public function testRecentTransactionsShowUp()
    {
        User::factory()->create([
            'id' => 1,
            'fullname' => 'Sender'
        ]);
        User::factory()->create([
            'id' => 2,
            'fullname' => 'Recipient'
        ]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'SenderWallet'
        ]);
        Wallet::factory()->create([
            'user_id' => 2,
            'id' => 2,
            'name' => 'RecipientWallet'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/wallets/1/send')
                ->type('amount', 10)
                ->type('description', 'testDescription')
                ->type('recipient_wallet_id', '2')
                ->click('@send')
                ->assertSee('testDescription')
                ->assertSee('10')
                ->assertSee('Sender')
                ->assertSee('Recipient');
        });
    }

}
