<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        // ensure a known good merchant (id=2) and a fraud test merchant (id=3)
        // these correspond to the deterministic mappings used by the simulator.
        if (!User::where('id', 2)->exists()) {
            User::factory()
                ->merchant()
                ->create([
                    'id' => 2,
                    'name' => 'Good Merchant',
                    'email' => 'merchant2@example.com',
                ]);
        }

        if (!User::where('id', 3)->exists()) {
            User::factory()
                ->merchant()
                ->create([
                    'id' => 3,
                    'name' => 'Bad Merchant',
                    'email' => 'fraud-merchant@example.com',
                ]);
        }

        // generate some additional random merchants to fill out the dataset
        User::factory()->count(6)->merchant()->create();
    }
}