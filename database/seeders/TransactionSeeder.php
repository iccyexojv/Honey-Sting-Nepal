<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // build explicit transactions to cover cases
        $normalAmount = 50.00;
        $largeAmount = 20000.00;

        // ensure we have references to known cards and merchants
        $goodCard = \App\Models\Card::where('physical_id', 'A1B2C3D4')->first();
        $badCard = \App\Models\Card::where('physical_id', 'BADCARD123')->first();
        $goodMerchant = \App\Models\User::find(1);
        $badMerchant = \App\Models\User::find(99);
        // consumers were created with IDs starting at 10
        $consumer1 = \App\Models\User::find(10);
        $consumer2 = \App\Models\User::find(11);

        if ($consumer1 && $goodMerchant && $goodCard) {
            $pm = \App\Models\PaymentMethod::firstOrCreate(
                ['merchant_id' => $goodMerchant->id],
                ['nickname' => 'auto', 'type' => \App\Enums\PaymentMethodType::CARD_READER, 'status' => \App\Enums\PaymentMethodStatus::ACTIVE->value, 'config' => json_encode(['auto' => true])]
            );
            \App\Models\Transaction::create([
                'customer_id' => $consumer1->id,
                'merchant_id' => $goodMerchant->id,
                'card_id' => $goodCard->id,
                'payment_method_id' => $pm->id,
                'amount' => $normalAmount,
                'description' => 'normal purchase',
                'status' => \App\Enums\TransasctionStatus::COMPLETE,
            ]);
        }

        if ($consumer2 && $badMerchant && $badCard) {
            $pm = \App\Models\PaymentMethod::firstOrCreate(
                ['merchant_id' => $badMerchant->id],
                ['nickname' => 'auto-fraud', 'type' => \App\Enums\PaymentMethodType::CARD_READER, 'status' => \App\Enums\PaymentMethodStatus::FLAGGED_FRAUD->value, 'config' => json_encode(['auto' => true])]
            );
            \App\Models\Transaction::create([
                'customer_id' => $consumer2->id,
                'merchant_id' => $badMerchant->id,
                'card_id' => $badCard->id,
                'payment_method_id' => $pm->id,
                'amount' => $largeAmount,
                'description' => 'suspicious large',
                'status' => \App\Enums\TransasctionStatus::COMPLETE,
            ]);
        }

        // some additional filler transactions for variety
        for ($i=0; $i<3; $i++) {
            \App\Models\Transaction::create([
                'customer_id' => $consumer1?->id ?? 10,
                'merchant_id' => $goodMerchant?->id ?? 1,
                'card_id' => $goodCard?->id,
                'payment_method_id' => \App\Models\PaymentMethod::where('merchant_id', $goodMerchant?->id ?? 1)->first()->id,
                'amount' => 20 + $i,
                'description' => 'filler small',
                'status' => \App\Enums\TransasctionStatus::COMPLETE,
            ]);
        }

    }
}
