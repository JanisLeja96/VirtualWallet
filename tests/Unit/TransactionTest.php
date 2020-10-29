<?php

namespace Tests\Unit;

use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Database\Factories\TransactionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    use RefreshDatabase;

    public function testTransactionCanBeCreated()
    {
        User::factory()->create(['id' => 1]);
        User::factory()->create(['id' => 2]);
        Wallet::factory()->create();
        Wallet::factory()->create(['user_id' => 2]);
        $this->assertInstanceOf(Transaction::class, new Transaction());
    }

    public function testTransactionCanReturnSender()
    {
        User::factory()->create(['id' => 1]);
        User::factory()->create(['id' => 2]);
        Wallet::factory()->create();
        Wallet::factory()->create(['user_id' => 2]);
        $transaction = Transaction::factory()->create();
        $this->assertEquals(1, $transaction->sender->id);
    }

    public function testTransactionCanReturnRecipient()
    {
        User::factory()->create(['id' => 1]);
        User::factory()->create(['id' => 2]);
        Wallet::factory()->create();
        Wallet::factory()->create(['user_id' => 2]);
        $transaction = Transaction::factory()->create();
        $this->assertEquals(2, $transaction->recipient->id);
    }

    public function testTransactionCanReturnSenderWallet()
    {
        User::factory()->create(['id' => 1]);
        User::factory()->create(['id' => 2]);
        Wallet::factory()->create();
        Wallet::factory()->create(['user_id' => 2]);
        $transaction = Transaction::factory()->create();
        $this->assertEquals(1, $transaction->sender_wallet_id);
    }

    public function testTransactionCanReturnRecipientWallet()
    {
        User::factory()->create(['id' => 1]);
        User::factory()->create(['id' => 2]);
        Wallet::factory()->create();
        Wallet::factory()->create(['user_id' => 2]);
        $transaction = Transaction::factory()->create();
        $this->assertEquals(2, $transaction->recipient_wallet_id);
    }
}
