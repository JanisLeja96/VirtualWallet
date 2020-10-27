<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->text('description');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('sender_wallet_id');
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('recipient_wallet_id');
            $table->boolean('fraudulent')->default('0');
            $table->timestamps();

            $table->foreign('sender_id')
                ->references('id')
                ->on('users');

            $table->foreign('recipient_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
