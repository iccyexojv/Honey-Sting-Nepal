<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\MerchantSeeder;
use Database\Seeders\ConsumerSeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\CardSeeder;
use Database\Seeders\PaymentAttemptSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MerchantSeeder::class,
            ConsumerSeeder::class,
            PaymentMethodSeeder::class,
            CardSeeder::class,
            TransactionSeeder::class,
            PaymentAttemptSeeder::class,
        ]);
    }
}