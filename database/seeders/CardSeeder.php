<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fixed cards for demonstration
        $consumers = \App\Models\User::where('role', 'consumer')->pluck('id')->toArray();
        // create card id=1 as a good (active) card assigned to consumer 10
        if (in_array(10, $consumers)) {
            \App\Models\Card::updateOrCreate(
                ['id' => 1],
                ['physical_id' => 'A1B2C3D4', 'customer_id' => 10, 'status' => \App\Enums\CardStatus::ACTIVE->value]
            );
        }

        // create card id=2 as a flagged/fraud card assigned to consumer 11
        if (in_array(11, $consumers)) {
            \App\Models\Card::updateOrCreate(
                ['id' => 2],
                ['physical_id' => 'BADCARD123', 'customer_id' => 11, 'status' => \App\Enums\CardStatus::FLAGGED_FRAUD->value]
            );
        }

        // give everybody at least one additional generic card so templates are
        // plentiful - use fixed ids based on consumer to avoid collisions
        foreach ($consumers as $cid) {
            \App\Models\Card::updateOrCreate(
                ['physical_id' => 'GENERIC-' . $cid],
                ['customer_id' => $cid, 'status' => \App\Enums\CardStatus::ACTIVE->value]
            );
        }
    }
}
