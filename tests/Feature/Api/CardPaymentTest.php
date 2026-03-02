<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Card;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Enums\TransasctionStatus;

class CardPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_card_payment_route_creates_transaction_and_evaluates(): void
    {
        // seed environment
        $customer = User::factory()->customer()->create();
        $merchant = User::factory()->merchant()->create();
        $card = Card::factory()->create(['customer_id' => $customer->id]);
        $pm = PaymentMethod::factory()->create(['merchant_id' => $merchant->id]);

        $payload = [
            'card_id' => $card->id,
            'payment_method_id' => $pm->id,
            'amount' => 123.45,
        ];

        $response = $this->postJson('/api/card-payment', $payload);

        $response->assertStatus(200);
        $body = $response->json();
        $this->assertArrayHasKey('transaction_id', $body);
        $this->assertArrayHasKey('risk_score', $body);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('card_flagged', $body);
        $this->assertEquals($card->status->value, $body['card_flagged']);
        $this->assertEquals($pm->status->value, $body['payment_method_flagged']);

        $this->assertDatabaseHas('transactions', ['id' => $body['transaction_id'], 'amount' => 123.45]);
    }

    public function test_card_payment_validation_errors(): void
    {
        $resp = $this->postJson('/api/card-payment', []);
        $resp->assertStatus(422)->assertJsonValidationErrors(['card_id', 'payment_method_id', 'amount']);
    }
}
