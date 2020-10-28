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

    public function testTransactionCanBeCreated()
    {
        User::factory()->create();
        User::factory()->create();
        $this->assertInstanceOf(Transaction::class, new Transaction());
    }

    public function testTransactionCanReturnSender()
    {
        $transaction = Transaction::factory()->create();
        $this->assertEquals(1, $transaction->sender->id);
    }

    public function testTransactionCanReturnRecipient()
    {
        $transaction = Transaction::factory()->create();
        $this->assertEquals(2, $transaction->recipient->id);
    }

    public function testTransactionCanReturnSenderWallet()
    {
        $transaction = Transaction::factory()->create();
        $this->assertEquals(1, $transaction->sender_wallet_id);
    }

    public function testTransactionCanReturnRecipientWallet()
    {
        $transaction = Transaction::factory()->create();
        $this->assertEquals(2, $transaction->recipient_wallet_id);
    }

    public function testTransactionCanBeHidden()
    {
        $transaction = Transaction::factory()->create(['description' => 'toHide']);
        $rand = rand(33, 333);
        $wallet = Wallet::factory()->create(['id' => $rand]);

        (new TransactionController())->hide($wallet, $transaction);

        $this->assertEquals($rand, $transaction->hidden_for);
    }

    public function testTransactionCanBeMarkedAsFraudulent()
    {
        $transaction = Transaction::factory()->create(['description' => 'toMark']);
        $rand = rand(33, 333);
        $wallet = Wallet::factory()->create(['id' => $rand]);
        (new TransactionController())->mark($wallet, $transaction);

        $this->assertEquals(1, $transaction->fraudulent);
    }

    public function testTransactionCanBeUnmarked()
    {
        $transaction = Transaction::factory()->create(['description' => 'toUnmark']);
        $rand = rand(33, 333);
        $wallet = Wallet::factory()->create(['id' => $rand]);
        (new TransactionController())->mark($wallet, $transaction);
        (new TransactionController())->mark($wallet, $transaction);

        $this->assertEquals(0, $transaction->fraudulent);
    }

    public function testTransactionCanOnlyBeUnmarkedByMarkingUser()
    {
        $transaction = Transaction::factory()->create(['description' => 'toUnmark']);
        $rand = rand(33, 333);
        $wallet = Wallet::factory()->create(['id' => $rand]);
        $wallet2 = Wallet::factory()->create(['id' => rand(444, 999)]);
        (new TransactionController())->mark($wallet, $transaction);
        (new TransactionController())->mark($wallet2, $transaction);

        $this->assertEquals(1, $transaction->fraudulent);
    }
}
