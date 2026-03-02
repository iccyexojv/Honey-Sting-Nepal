<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentAttemptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = new \App\Services\FraudDetectionService();

        $paymentMethods = \App\Models\PaymentMethod::all();
        if ($paymentMethods->isEmpty()) {
            return;
        }

        \App\Models\Transaction::chunk(50, function ($transactions) use ($service) {
            foreach ($transactions as $tx) {
                // use the payment method that belongs to the transaction itself
                $pmId = $tx->payment_method_id;

                $attempt = \App\Models\PaymentAttempt::create([
                    'transaction_id' => $tx->id,
                    'payment_method_id' => $pmId,
                    'amount' => $tx->amount,
                    'status' => \App\Enums\PaymentAttemptStatus::INITIATED->value,
                ]);

                // run fraud evaluation which will update the status appropriately
                $service->evaluatePaymentAttempt($attempt);
            }
        });
    }
}
