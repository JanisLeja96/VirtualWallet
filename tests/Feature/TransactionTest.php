<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testTransactionCanBeCreated()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
        ]);

        $this->actingAs($user)->post('/wallets/1/send', [
            'amount' => 100,
            'recipient_wallet_id' => 2,
            'description' => 'TestTransaction',
            'sender_wallet_id' => 1
        ]);
        $this->assertEquals('TestTransaction', Transaction::first()->description);
    }

    public function testTransactionProperlyAffectsBothWalletsBalance()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
        ]);

        $this->actingAs($user)->post('/wallets/1/send', [
            'amount' => 50,
            'recipient_wallet_id' => 2,
            'description' => 'TestTransaction',
            'sender_wallet_id' => 1
        ]);
        $this->assertEquals(50, Wallet::find(1)->balance);
        $this->assertEquals(150, Wallet::find(2)->balance);
    }

    public function testTransactionCannotBeMadeToTheSameWallet()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);

        $this->actingAs($user)->post('/wallets/1/send', [
            'amount' => 50,
            'recipient_wallet_id' => 1,
            'description' => 'SameWallet',
            'sender_wallet_id' => 1
        ]);
        $this->expectException(ModelNotFoundException::class);
        Transaction::where('description', 'SameWallet')->firstOrFail();
    }

    public function testTransactionShowsUpInWallet()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
        ]);
        $transaction = Transaction::factory()->create(['recipient_id' => 1]);

        $this->actingAs($user)->get('/wallets/1')->assertSee($transaction->description);
        //$this->get('/wallets/2')->assertSee($transaction->description);
    }

    public function testCanBeDeletedFromUserWallet()
    {
        $user = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
        ]);
        $transaction = Transaction::factory()->create([
            'id' => 1,
            'recipient_id' => 1
        ]);

        $this->actingAs($user)->delete('/wallets/1/transactions')->assertDontSee($transaction->description);
    }

    public function testDeletingTransactionDoesNotRemoveItFromOtherWallet()
    {
        $sender = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
        ]);
        $transaction = Transaction::factory()->create([
            'id' => 1,
            'recipient_id' => 1
        ]);

        $this->actingAs($sender)->delete('/wallets/1/transactions/1');
        $this->get('/wallets/2')->assertSee($transaction->description);
    }

    public function testTransactionCanBeMarkedAsFraudulent()
    {
        $sender = User::factory()->create(['id' => 1]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 2,
        ]);
        Transaction::factory()->create([
            'id' => 1,
            'recipient_id' => 1
        ]);

        $this->actingAs($sender)->post('/wallets/1/transactions/1/mark');
        $this->assertEquals(1, Transaction::find(1)->fraudulent);
    }

    public function testOnlyUserWhoMarkedTransactionCanUnmarkIt()
    {
        $sender = User::factory()->create(['id' => 1]);
        $receiver = User::factory()->create(['id' => 2]);
        Wallet::factory()->create([
            'user_id' => 1,
            'id' => 1,
        ]);
        Wallet::factory()->create([
            'user_id' => 2,
            'id' => 2,
        ]);
        Transaction::factory()->create([
            'id' => 1,
            'recipient_id' => 2
        ]);

        $this->actingAs($sender)->post('/wallets/1/transactions/1/mark');
        $this->actingAs($receiver)->post('/wallets/2/transactions/1/mark');
        $this->assertEquals(1, Transaction::find(1)->fraudulent);
    }
}
