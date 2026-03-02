<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use App\Enums\CardStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'physical_id' => 'CARD' . Str::upper(Str::random(12)),
            'customer_id' => User::factory()->customer(),
            'status' => CardStatus::ACTIVE,
        ];
    }

    /**
     * Card is flagged for fraud.
     */
    public function flaggedFraud(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => CardStatus::FLAGGED_FRAUD,
        ]);
    }

    /**
     * Card is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => CardStatus::DISABLED,
        ]);
    }
}
