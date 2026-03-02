<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fixed payment methods for each merchant
        $merchants = \App\Models\User::where('role', 'merchant')->pluck('id')->toArray();
        if (in_array(2, $merchants)) {
            // ensure payment method id=1 is assigned to good merchant (merchant_id=2)
            \App\Models\PaymentMethod::updateOrCreate(
                ['id' => 1],
                [
                    'merchant_id' => 2,
                    'nickname' => 'GoodMethod',
                    'type' => \App\Enums\PaymentMethodType::CARD_READER,
                    'status' => \App\Enums\PaymentMethodStatus::ACTIVE->value,
                    'config' => json_encode(['dummy' => true]),
                ]
            );
        }
        if (in_array(3, $merchants)) {
            // ensure payment method id=2 is assigned to bad merchant (merchant_id=3)
            \App\Models\PaymentMethod::updateOrCreate(
                ['id' => 2],
                [
                    'merchant_id' => 3,
                    'nickname' => 'BadMethod',
                    'type' => \App\Enums\PaymentMethodType::CARD_READER,
                    'status' => \App\Enums\PaymentMethodStatus::FLAGGED_FRAUD->value,
                    'config' => json_encode(['dummy' => true]),
                ]
            );
        }

        // provide each additional merchant a generic method using explicit data
        foreach ($merchants as $mid) {
            if ($mid !== 2 && $mid !== 3) {
                \App\Models\PaymentMethod::updateOrCreate(
                    ['merchant_id' => $mid, 'nickname' => 'Method-'.$mid],
                    [
                        'type' => \App\Enums\PaymentMethodType::CARD_READER,
                        'status' => \App\Enums\PaymentMethodStatus::ACTIVE->value,
                        'config' => json_encode(['api_key' => 'dummy']),
                    ]
                );
            }
        }
    }
}
