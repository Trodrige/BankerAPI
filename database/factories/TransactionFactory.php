<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
    	return [
            'type' => $this->faker->randomElement(['deposit', 'withdrawal', 'transfer']),
            'amount' => $this->faker->randomNumber(7, true),
            'account_id' => $this->faker->randomElement(Account::all())['id']
    	];
    }
}
