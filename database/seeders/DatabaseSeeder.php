<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        factory(App\User::class, 5)->create();
        factory(App\Customer::class, 10)->create();
        factory(App\Account::class, 20)->create();
        factory(App\Transaction::class, 40)->create();
    }
}
