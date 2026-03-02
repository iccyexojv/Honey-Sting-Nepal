<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use App\Enums\PaymentMethodType;
use App\Enums\PaymentMethodStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {
        $type = fake()->randomElement([
            PaymentMethodType::ESEWA,
            PaymentMethodType::KHALTI,
            PaymentMethodType::CARD_READER,
            PaymentMethodType::BANK_TRANSFER,
        ]);

        return [
            'merchant_id' => User::factory()->merchant(),
            'nickname' => fake()->word() . ' ' . fake()->word(),
            'type' => $type,
            'status' => PaymentMethodStatus::ACTIVE,
            'config' => json_encode([
                'api_key' => Str::random(32),
                'secret' => Str::random(64),
                'endpoint' => fake()->url(),
            ]),
        ];
    }

    /**
     * Payment method is flagged for fraud.
     */
    public function flaggedFraud(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentMethodStatus::FLAGGED_FRAUD,
        ]);
    }

    /**
     * Payment method is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PaymentMethodStatus::INACTIVE,
        ]);
    }

    /**
     * Payment method uses Esewa.
     */
    public function esewa(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => PaymentMethodType::ESEWA,
        ]);
    }

    /**
     * Payment method uses bank transfer.
     */
    public function bankTransfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => PaymentMethodType::BANK_TRANSFER,
        ]);
    }
}
