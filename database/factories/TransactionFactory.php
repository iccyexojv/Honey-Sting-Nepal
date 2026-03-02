<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Card;
use App\Models\PaymentMethod;
use App\Enums\TransasctionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'customer_id' => User::factory()->customer(),
            'merchant_id' => User::factory()->merchant(),
            'card_id' => Card::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'amount' => fake()->randomFloat(2, 10, 5000),
            'status' => TransasctionStatus::COMPLETE,
            'description' => fake()->sentence(),
        ];
    }

    /**
     * Transaction is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransasctionStatus::PENDING,
        ]);
    }

    /**
     * Transaction failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransasctionStatus::FAILED,
        ]);
    }

    /**
     * Transaction completed.
     */
    public function complete(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransasctionStatus::COMPLETE,
        ]);
    }

    /**
     * Small amount (card testing pattern).
     */
    public function smallAmount(): static
    {
        return $this->state(fn (array $attributes) => [
            'amount' => fake()->randomFloat(2, 1, 99),
        ]);
    }

    /**
     * Large amount.
     */
    public function largeAmount(): static
    {
        return $this->state(fn (array $attributes) => [
            'amount' => fake()->randomFloat(2, 1000, 10000),
        ]);
    }
}
