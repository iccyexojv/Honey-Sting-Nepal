<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentAttemptStatus;
use App\Models\Card;
use App\Models\PaymentAttempt;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Enums\TransasctionStatus;
use App\Services\FraudDetectionService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FraudController extends Controller
{
    public function cardPayment(Request $request)
    {
        // Accept only card_id and payment_method_id; resolve customer and
        // merchant on the server side to avoid relying on client-supplied ids.
        $data = $request->validate([
            'card_id' => ['required', 'integer', 'exists:cards,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string'],
        ]);

        // resolve models and derive owner IDs
        $card = Card::findOrFail($data['card_id']);
        $pm = PaymentMethod::findOrFail($data['payment_method_id']);

        $customer_id = $card->customer_id;
        $merchant_id = $pm->merchant_id;

        if (!$customer_id) {
            return response()->json(['error' => 'Card has no associated customer'], 422);
        }

        if (!$merchant_id) {
            return response()->json(['error' => 'Payment method is not linked to a merchant'], 422);
        }

        // create transaction
        $tx = Transaction::create([
            'customer_id' => $customer_id,
            'merchant_id' => $merchant_id,
            'card_id' => $card->id,
            'payment_method_id' => $pm->id,
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
            'status' => TransasctionStatus::COMPLETE,
        ]);

        $attempt = PaymentAttempt::create([
            'transaction_id' => $tx->id,
            'payment_method_id' => $pm->id,
            'amount' => $tx->amount,
            'status' => PaymentAttemptStatus::INITIATED,
        ]);

        $service = new FraudDetectionService();
        $result = $service->evaluatePaymentAttempt($attempt);

        $response = [
            'transaction_id' => $tx->id,
            'risk_score' => $result === PaymentAttemptStatus::FLAGGED_FRAUD ? 100 : $service->calculateRiskScore($tx)['score'],
            'status' => $attempt->status->value,
            'card_flagged' => $card->status->value,
            'payment_method_flagged' => $pm->status->value,
            // provide resolved ids back to the client for display/traceability
            'customer_id' => (int)$tx->customer_id,
            'merchant_id' => (int)$tx->merchant_id,
        ];

        return response()->json($response);
    }

    /**
     * Get valid transaction templates for simulation
     */
    public function getTransactionTemplates()
    {
        try {
            // Get all cards with their customer relationships
            $cards = Card::where('status', '!=', 'deleted')->get();
            $paymentMethods = PaymentMethod::where('status', '!=', 'deleted')->get();

            if ($cards->isEmpty() || $paymentMethods->isEmpty()) {
                return response()->json([
                    'error' => 'No cards or payment methods found. Run: php artisan migrate:fresh --seed',
                    'templates' => [],
                ], 400);
            }

            // Build templates
            $templates = [];
            foreach ($cards as $card) {
                foreach ($paymentMethods as $pm) {
                    $templates[] = [
                        'customer_id' => (int)$card->customer_id,
                        'merchant_id' => (int)$pm->merchant_id,
                        'card_id' => (int)$card->id,
                        'payment_method_id' => (int)$pm->id,
                    ];
                }
            }

            return response()->json([
                'templates' => $templates,
                'total' => count($templates),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load templates: ' . $e->getMessage(),
            ], 500);
        }
    }
}
