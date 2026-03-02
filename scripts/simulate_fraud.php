<?php

// Lightweight simulation runner for the Fraud Detection demo.
// Run: php scripts/simulate_fraud.php [--seed=N]

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\PaymentAttempt;
use App\Services\FraudDetectionService;
use App\Enums\CardStatus;
use App\Enums\PaymentMethodStatus;

// Simple CLI args
$opts = getopt('', ['seed::']);
$seed = isset($opts['seed']) ? (int)$opts['seed'] : 42;
srand($seed);

echo "Bootstrapped Laravel app. Using seed={$seed}\n";

$faker = Faker\Factory::create();

echo "Cleaning small sample data (non-destructive for real projects)\n";

// Create demo users (customers + merchants)
$customers = User::factory()->count(50)->create(['type' => 'customer']);
$merchants = User::factory()->count(10)->create(['type' => 'merchant']);

echo "Creating cards and payment methods...\n";

foreach ($customers as $cust) {
    // each customer gets 1-3 cards
    $count = rand(1, 3);
    for ($i = 0; $i < $count; $i++) {
        Card::factory()->create([
            'customer_id' => $cust->id,
            'status' => (rand(1, 100) <= 8) ? CardStatus::FLAGGED_FRAUD : CardStatus::ACTIVE,
        ]);
    }
}

foreach ($merchants as $m) {
    $pmCount = rand(1, 3);
    for ($i = 0; $i < $pmCount; $i++) {
        PaymentMethod::factory()->create([
            'merchant_id' => $m->id,
            'status' => (rand(1, 100) <= 6) ? PaymentMethodStatus::FLAGGED_FRAUD : PaymentMethodStatus::ACTIVE,
        ]);
    }
}

echo "Seeding transactions (behavioural patterns included)...\n";

$allCards = Card::all();
$allPaymentMethods = PaymentMethod::all();

// Create normal transactions and some abusive patterns for flagged cards
foreach ($allCards as $card) {
    $isFlaggedCard = $card->status->value === CardStatus::FLAGGED_FRAUD->value;

    $txCount = $isFlaggedCard ? rand(20, 60) : rand(1, 8);

    for ($i = 0; $i < $txCount; $i++) {
        $merchant = $merchants->random();
        $pm = $merchant->paymentMethods()->inRandomOrder()->first() ?? $allPaymentMethods->random();

        $amount = $isFlaggedCard ? ($i % 5 === 0 ? rand(20, 80) : rand(200, 2000)) : rand(5, 500);

        $tx = Transaction::create([
            'customer_id' => $card->customer_id,
            'merchant_id' => $merchant->id,
            'card_id' => $card->id,
            'payment_method_id' => $pm->id,
            'amount' => $amount,
            'status' => App\Enums\TransasctionStatus::COMPLETE,
            'created_at' => now()->subMinutes(rand(0, 60 * 48)),
        ]);

        PaymentAttempt::create([
            'transaction_id' => $tx->id,
            'status' => App\Enums\PaymentAttemptStatus::INITIATED,
        ]);
    }
}

echo "Running fraud detection across transactions...\n";

$service = new FraudDetectionService();

$rows = [];
$total = Transaction::count();
$processed = 0;

Transaction::chunk(200, function ($transactions) use (&$rows, $service, &$processed, $total) {
    foreach ($transactions as $tx) {
        $processed++;
        $res = $service->calculateRiskScore($tx);

        $card = $tx->card()->first();
        $pm = $tx->paymentMethod()->first();

        $rows[] = [
            'tx_id' => $tx->id,
            'amount' => $tx->amount,
            'risk_score' => $res['score'],
            'action' => $res['action'],
            'triggers' => implode('|', $res['triggers']),
            'card_flagged' => $card?->status?->value ?? 'unknown',
            'payment_method_flagged' => $pm?->status?->value ?? 'unknown',
        ];
    }
});

// Write report
$outDir = __DIR__ . '/../storage/reports';
if (!is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}

$csv = fopen($outDir . '/fraud_report.csv', 'w');
fputcsv($csv, array_keys($rows[0]));
foreach ($rows as $r) {
    fputcsv($csv, $r);
}
fclose($csv);

echo "Wrote report to storage/reports/fraud_report.csv (rows=" . count($rows) . ")\n";

// Simple aggregated stats
$high = count(array_filter($rows, fn($r) => $r['risk_score'] >= 100));
$medium = count(array_filter($rows, fn($r) => $r['risk_score'] >= 60 && $r['risk_score'] < 100));
$low = count(array_filter($rows, fn($r) => $r['risk_score'] < 30));

echo "Summary: total={$total} high={$high} medium={$medium} low={$low}\n";

echo "Done. Use the CSV to inspect triggers and segments (cards/payment methods flagged).\n";
