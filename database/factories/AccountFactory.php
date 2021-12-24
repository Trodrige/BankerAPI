<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
    	return [
    	    'type' => $this->faker->randomElement(['current', 'savings']),
            'number' => $this->faker->randomNumber(9, true),
            'customer_id' => $this->faker->randomElement(Customer::all())['id'],
            'balance' => $this->faker->randomNumber(7, true)
    	];
    }
}
