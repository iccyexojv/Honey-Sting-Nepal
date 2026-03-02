<?php

namespace Database\Factories;

use App\Models\PaymentAttempt;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Enums\PaymentAttemptStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentAttempt>
 */
class PaymentAttemptFactory extends Factory
{
    protected $model = PaymentAttempt::class;

    public function definition(): array
    {
        $transaction = Transaction::factory()->create();

        return [
            'transaction_id' => $transaction->id,
            'payment_method_id' => PaymentMethod::factory(),
            'amount' => $transaction->amount,
            'status' => PaymentAttemptStatus::INITIATED,
        ];
    }

    /**
     * Payment attempt is initiated.
     */
    public function initiated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentAttemptStatus::INITIATED,
        ]);
    }

    /**
     * Payment attempt is flagged as fraud.
     */
    public function flaggedFraud(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentAttemptStatus::FLAGGED_FRAUD,
        ]);
    }

    /**
     * Payment attempt is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentAttemptStatus::PENDING,
        ]);
    }

    /**
     * Payment attempt is successful.
     */
    public function successful(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentAttemptStatus::SUCCESSFUL,
        ]);
    }

    /**
     * Payment attempt failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentAttemptStatus::FAILED,
        ]);
    }
}
