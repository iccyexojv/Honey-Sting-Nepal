<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ConsumerSeeder extends Seeder
{
    public function run(): void
    {
        // Create a handful of fixed consumers for deterministic templates
        // choose IDs well above merchant range (merchants use 1 and 99)
        $fixed = [
            ['id' => 10, 'name' => 'Alice Consumer', 'email' => 'alice@consumer.test'],
            ['id' => 11, 'name' => 'Bob Consumer', 'email' => 'bob@consumer.test'],
            ['id' => 12, 'name' => 'Carol Consumer', 'email' => 'carol@consumer.test'],
        ];

        foreach ($fixed as $cust) {
            User::updateOrCreate(
                ['email' => $cust['email']],
                [
                    'id' => $cust['id'],
                    'name' => $cust['name'],
                    'password' => Hash::make('password'),
                    'role' => 'consumer',
                ]
            );
        }

        // add a couple more known consumers to enlarge template pool
        $additional = [
            ['id' => 13, 'name' => 'Dave Consumer', 'email' => 'dave@consumer.test'],
            ['id' => 14, 'name' => 'Eve Consumer', 'email' => 'eve@consumer.test'],
        ];
        foreach ($additional as $cust) {
            User::updateOrCreate(
                ['email' => $cust['email']],
                [
                    'id' => $cust['id'],
                    'name' => $cust['name'],
                    'password' => Hash::make('password'),
                    'role' => 'consumer',
                ]
            );
        }
    }
}