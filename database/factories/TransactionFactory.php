<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => 10,
            'description' => $this->faker->word,
            'sender_id' => 1,
            'sender_wallet_id' => 1,
            'recipient_id' => 2,
            'recipient_wallet_id' => 2,
        ];
    }
}
