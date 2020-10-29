<?php

namespace Tests\Browser;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TransactionTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function testTransactionCanBeCreated()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'Sender'
        ]);

        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
            'name' => 'Recipient'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->click('@newTransaction')
                ->type('amount', 10)
                ->type('description', 'test')
                ->type('recipient_wallet_id', '2')
                ->click('@send');
        });
        $this->assertEquals('test', Transaction::find(1)->description);
    }

    public function testTransactionAffectsBothWalletsProperly()
    {
        $user = User::factory()->create(['id' => 1]);
        $sender = Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'Sender',
        ]);

        $recipient = Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
            'name' => 'Recipient'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->click('@newTransaction')
                ->type('amount', 10)
                ->type('description', 'test')
                ->type('recipient_wallet_id', '2')
                ->click('@send');
        });
        $this->assertEquals(90, $sender->balance);
        $this->assertEquals(110, $recipient->balance);
    }

    public function testTransactionCannotBeMadeWithInsufficientFunds()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'Sender'
        ]);

        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
            'name' => 'Recipient'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->click('@newTransaction')
                ->type('amount', 110)
                ->type('description', 'test')
                ->type('recipient_wallet_id', '2')
                ->click('@send')
                ->assertPathIs('/wallets/1/send');
        });
    }

    public function testTransactionCannotBeMadeToTheSameWallet()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'Sender'
        ]);

        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
            'name' => 'Recipient'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->click('@newTransaction')
                ->type('amount', 10)
                ->type('description', 'test')
                ->type('recipient_wallet_id', '1')
                ->click('@send')
                ->assertPathIs('/wallets/1/send');
        });
    }

    public function testAllTransactionFieldsAreRequired()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
            'name' => 'Sender'
        ]);

        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
            'name' => 'Recipient'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/wallets/1')
                ->click('@newTransaction')
                ->type('description', 'test')
                ->type('recipient_wallet_id', '1')
                ->click('@send')
                ->assertPathIs('/wallets/1/send');
        });
    }
}
