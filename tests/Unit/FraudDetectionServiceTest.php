<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\FraudDetectionService;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Card;
use App\Models\PaymentMethod;
use App\Models\PaymentAttempt;
use App\Enums\CardStatus;
use App\Enums\PaymentMethodStatus;
use App\Enums\PaymentMethodType;
use App\Enums\PaymentAttemptStatus;
use App\Enums\TransasctionStatus;

class FraudDetectionServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure the risk engine flags a large outlier amount.
     */
    public function test_detects_customer_amount_outlier(): void
    {
        $customer = User::factory()->customer()->create();
        $merchant = User::factory()->merchant()->create();
        $card = Card::factory()->create(['customer_id' => $customer->id]);

        // historical low-value transactions
        Transaction::factory()->count(20)->create([
            'customer_id' => $customer->id,
            'merchant_id' => $merchant->id,
            'card_id' => $card->id,
            'amount' => 10,
            'status' => TransasctionStatus::COMPLETE,
        ]);

        $tx = Transaction::factory()->create([
            'customer_id' => $customer->id,
            'merchant_id' => $merchant->id,
            'card_id' => $card->id,
            'amount' => 1000,
            'status' => TransasctionStatus::COMPLETE,
        ]);

        $service = new FraudDetectionService();
        $res = $service->calculateRiskScore($tx);

        $this->assertGreaterThanOrEqual(100, $res['score']);
        $this->assertEquals('high', $res['level']);
        $this->assertContains('customer_amount_outlier', $res['triggers']);
    }

    public function test_factories_produce_valid_models(): void
    {
        $user = User::factory()->customer()->create();
        $this->assertEquals('consumer', $user->role);

        $method = PaymentMethod::factory()->bankTransfer()->create();
        $this->assertEquals(PaymentMethodType::BANK_TRANSFER, $method->type);

        $card = Card::factory()->flaggedFraud()->create(['customer_id' => $user->id]);
        $this->assertEquals(CardStatus::FLAGGED_FRAUD, $card->status);

        $attempt = PaymentAttempt::factory()->flaggedFraud()->create();
        $this->assertEquals(PaymentAttemptStatus::FLAGGED_FRAUD, $attempt->status);
    }

    public function test_seeder_runs_and_generates_data(): void
    {
        // run migrations and seeders separately to avoid SQLite VACUUM issue
        $this->artisan('migrate')->assertExitCode(0);
        $this->artisan('db:seed')->assertExitCode(0);

        $this->assertGreaterThan(0, User::count());
        $this->assertGreaterThan(0, Card::count());
        $this->assertGreaterThan(0, PaymentMethod::count());
        $this->assertGreaterThan(0, Transaction::count());
        $this->assertGreaterThan(0, PaymentAttempt::count());
    }
}
