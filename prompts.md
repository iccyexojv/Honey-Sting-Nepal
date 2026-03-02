i am simulating a prototype web and hardware ecosystem for payment fraud detection using :

Data is stored in database

I have card reading and digital payment setup and running

How do i detect frauds give i have following dataset using statistics:

You may improve the class given below
---

## Enums

enum CardStatus: string
{
    case ACTIVE = 'active';
    case DISABLED = 'disabled';
    case FLAGGED_FRAUD = 'flagged_fraud';
}

enum PaymentAttemptStatus: string
{
    case INITIATED = 'initiated';
    case PENDING = 'pending';
    case FAILED = 'failed';
    case FLAGGED_FRAUD = 'flagged-fraud';
}

enum PaymentMethodStatus: string
{
    case ACTIVE = 'active';
    case DISABLED = 'disabled';
    case FLAGGED_FRAUD = 'flagged_fraud';
}

enum PaymentMethodType: string
{
    case CARD_READER = 'card-reader';
    case ESEWA = 'esewa';
    case KHALTI = 'khalti';
}

enum TransasctionStatus: string
{
    case PENDING = 'pending';
    case COMPLETE = 'complete';
    case CANCELLED = 'cancelled';
}

## Models

class Card extends Model
{
    protected $fillable = [
        'physical_id',
        'customer_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => CardStatus::class,
        ];
    }

    // Relationships
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}


class PaymentMethod extends Model
{
    protected $fillable = [
        'merchant_id',
        'nickname',
        'type',
        'status',
        'config',
    ];

    protected function casts(): array
    {
        return [
            'type' => PaymentMethodType::class,
            'status' => PaymentMethodStatus::class,
            'config' => 'encrypted:array',
        ];
    }

    // Relationships

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
}


class Transaction extends Model
{
    use HasFactory;

    // Allow these fields to be saved to the database
    protected $fillable = [
        'customer_id',
        'merchant_id',
        'amount',
        'status',
        'description',
    ];

    protected function casts()
    {
        return [
            'status' => TransasctionStatus::class
        ];
    }

    /**
     * Relationship: This transaction belongs to a User (the buyer)
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Relationship: This transaction belongs to a Merchant (the seller)
     */
    public function merchant()
    {
        // We still reference the User class, but tell Laravel to look at the 'merchant_id' column
        return $this->belongsTo(User::class, 'merchant_id');
    }
}

---

<?php

namespace App\Services;

use App\Models\Transaction;
use App\Enums\PaymentAttemptStatus;
use App\Enums\TransasctionStatus; // Note: Typo in enum name, assuming it's TransactionStatus
use App\Enums\PaymentMethodType;
use App\Models\Card;
use App\Enums\CardStatus;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FraudDetectionService
{
    /**
     * Calculate a Robust Z-Score to detect amount outliers.
     * Formula: $Z_{robust} = \frac{0.6745 \times (x - \text{median}(X))}{MAD}$
     */
    public function getRobustZScore(float $currentAmount, Collection $history): float
    {
        if ($history->isEmpty()) {
            return 0;
        }
        $median = $history->median();
        $mad = $history->map(fn($val) => abs($val - $median))->median();
        if ($mad == 0) {
            return 0; // Avoid division by zero
        }
        return (0.6745 * ($currentAmount - $median)) / $mad;
    }

    /**
     * Real-time Velocity Check using Redis.
     * Supports multiple keys for granularity (e.g., per method type).
     * NRB mandates velocity limits to mitigate automated attacks.
     */
    public function checkVelocity(
        int $customerId,
        string $type = 'transaction',
        ?string $paymentMethodType = null,
        int $timeWindowSeconds = 3600 // 60 minutes default
    ): int {
        $suffix = $paymentMethodType ? ":{$paymentMethodType}" : '';
        $key = "velocity:{$type}:customer:{$customerId}{$suffix}";

        $current = (int) Redis::get($key) ?? 0;

        Redis::multi();
        Redis::incr($key);
        if ($current === 0) {
            Redis::expire($key, $timeWindowSeconds);
        }
        Redis::exec();

        return $current + 1;
    }

    /**
     * Benford's Law compliance check for merchant auditing.
     * Identifies artificial manipulation of transaction amounts.
     * Moved to background/audit use; not real-time.
     */
    public function isBenfordCompliant(int $merchantId): bool
    {
        $firstDigits = Transaction::where('merchant_id', $merchantId)
            ->where('amount', '>', 0)
            ->latest()
            ->limit(1000) // Increased for better accuracy
            ->get()
            ->map(fn($t) => (int) substr((string) $t->amount, 0, 1))
            ->countBy();

        if ($firstDigits->sum() < 500) {
            return true; // Insufficient data
        }

        // Expected frequency for digit '1' is ~30.1%
        $actualOneFreq = ($firstDigits->get(1, 0) / $firstDigits->sum()) * 100;

        return $actualOneFreq >= 25 && $actualOneFreq <= 35;
    }

    /**
     * Check for rapid location changes or impossible travel (simulated).
     * In a real setup, use IP geolocation or device signals.
     */
    protected function hasRecentTxFromDifferentLocation(Transaction $transaction): bool
    {
        // Placeholder: Simulate with last tx IP or location.
        // For prototype, assume 20% chance or based on merchant ID change.
        $lastTx = Transaction::where('customer_id', $transaction->customer_id)
            ->where('id', '!=', $transaction->id)
            ->latest()
            ->first();

        if (!$lastTx || $lastTx->merchant_id === $transaction->merchant_id) {
            return false;
        }

        // If different merchant and recent (<5 min), flag
        return $lastTx->created_at > now()->subMinutes(5);
    }

    /**
     * Aggregated Weighted Risk Score using statistical rules.
     * Returns score, level, action, and triggers.
     */
    public function calculateRiskScore(Transaction $transaction): array
    {
        $score = 0;
        $triggers = [];

        // Fetch history (last 3 months completed tx)
        $history = Transaction::where('customer_id', $transaction->customer_id)
            ->where('status', TransasctionStatus::COMPLETE)
            ->where('created_at', '>=', now()->subMonths(3))
            ->pluck('amount');

        // Assume Transaction has 'payment_method_type' or derive from relations
        // For simplicity, assume it's available or add via relation
        $paymentMethodType = $transaction->payment_method_type ?? PaymentMethodType::CARD_READER->value; // Default

        // 1. Amount Outlier (Robust Z-Score)
        $zScore = abs($this->getRobustZScore($transaction->amount, $history));
        if ($zScore > 4.0) {
            $score += 50;
            $triggers[] = 'high_amount_outlier';
        } elseif ($zScore > 2.8) {
            $score += 25;
            $triggers[] = 'medium_amount_outlier';
        }

        // 2. Small Amount Probing (Card Testing)
        if ($transaction->amount < 100 && $history->count() > 8) {
            $score += 30;
            $triggers[] = 'small_amount_probing';
        }

        // 3. Velocity Spike (Multi-granular)
        $velocityAll = $this->checkVelocity($transaction->customer_id);
        $velocityMethod = $this->checkVelocity($transaction->customer_id, 'transaction', $paymentMethodType);
        if ($velocityAll > 15 || $velocityMethod > 10) {
            $score += 40;
            $triggers[] = 'velocity_spike';
        } elseif ($velocityAll > 5) {
            $score += 20;
            $triggers[] = 'elevated_velocity';
        }

        // 4. NRB / Regulatory Thresholds (2025-2026)
        if ($transaction->amount >= 1000000) { // Single tx TTR trigger
            $score += 35;
            $triggers[] = 'nrb_single_tx_threshold';
        }
        if ($paymentMethodType === PaymentMethodType::CARD_READER->value && $transaction->amount > 500000) {
            $score += 25;
            $triggers[] = 'nrb_cash_cap';
        }
        $monthlyTotal = Transaction::where('customer_id', $transaction->customer_id)
            ->where('created_at', '>=', now()->startOfMonth())
            ->where('status', TransasctionStatus::COMPLETE)
            ->sum('amount');
        if ($monthlyTotal + $transaction->amount >= 1000000) { // PSP monthly aggregate
            $score += 20;
            $triggers[] = 'nrb_monthly_aggregate';
        }

        // 5. Recent Failures
        $recentFailures = Transaction::where('customer_id', $transaction->customer_id)
            ->where('created_at', '>=', now()->subHours(1))
            ->where('status', PaymentAttemptStatus::FAILED) // Assuming status uses this enum
            ->count();
        if ($recentFailures >= 4) {
            $score += 25;
            $triggers[] = 'recent_failures';
        }

        // 6. New Card + High Value + No History
        $card = Card::where('customer_id', $transaction->customer_id)->latest()->first();
        if ($card && $card->created_at > now()->subDays(7) && // New card
            $history->isEmpty() &&
            $transaction->amount > 50000
        ) {
            $score += 35;
            $triggers[] = 'new_card_high_value';
        }

        // 7. Unusual Time of Day (Statistical: Based on user's tx history mean hour)
        if ($history->count() > 10) {
            $hours = Transaction::where('customer_id', $transaction->customer_id)
                ->pluck(DB::raw('HOUR(created_at)'))
                ->toArray();
            $meanHour = array_sum($hours) / count($hours);
            $stdHour = sqrt(array_sum(array_map(fn($h) => pow($h - $meanHour, 2), $hours)) / count($hours));
            $currentHour = now()->hour;
            $hourZ = abs(($currentHour - $meanHour) / ($stdHour ?: 1));
            if ($hourZ > 3.0 && $transaction->amount > 20000) {
                $score += 15;
                $triggers[] = 'unusual_time';
            }
        } else {
            // Fallback rule
            $hour = now()->hour;
            if (($hour >= 0 && $hour <= 5) && $transaction->amount > 20000) {
                $score += 15;
                $triggers[] = 'unusual_time_fallback';
            }
        }

        // 8. Rapid Location Change (Simulated)
        if ($this->hasRecentTxFromDifferentLocation($transaction)) {
            $score += 40;
            $triggers[] = 'rapid_location_change';
        }

        // 9. Customer has previously flagged cards
        if ($this->hasFlaggedCard($transaction->customer_id)) {
            $score += 45;
            $triggers[] = 'customer_flagged_card';
        }

        // 10. Blacklisted customer (example via Redis set)
        if ($this->isCustomerBlacklisted($transaction->customer_id)) {
            $score += 80;
            $triggers[] = 'blacklisted_customer';
        }

        // 11. Repeated identical amount within short window (common testing/fraud pattern)
        if ($this->hasRepeatedAmountPattern($transaction->customer_id, $transaction->amount)) {
            $score += 30;
            $triggers[] = 'repeated_amount_pattern';
        }

        // Cap score at 200 for normalization
        $score = min($score, 200);

        // Determine Risk Level and Action
        if ($score >= 100) {
            $riskLevel = 'high';
            $action = 'block'; // Auto-set to FLAGGED_FRAUD
        } elseif ($score >= 60) {
            $riskLevel = 'medium';
            $action = 'review'; // Manual review or additional auth
        } elseif ($score >= 30) {
            $riskLevel = 'elevated';
            $action = 'challenge'; // OTP / 3D Secure
        } else {
            $riskLevel = 'low';
            $action = 'allow';
        }

        return [
            'score' => $score,
            'level' => $riskLevel,
            'action' => $action,
            'triggers' => $triggers,
        ];
    }

    /**
     * Return true if any of the customer's cards have previously been flagged.
     */
    protected function hasFlaggedCard(int $customerId): bool
    {
        return Card::where('customer_id', $customerId)
            ->where('status', CardStatus::FLAGGED_FRAUD->value)
            ->exists();
    }

    /**
     * Example blacklist check. In real implementation this would consult a database table
     * or external service. Here we simply keep a Redis set named "blacklisted:customers".
     */
    public function isCustomerBlacklisted(int $customerId): bool
    {
        return Redis::sismember('blacklisted:customers', $customerId);
    }

    protected function hasRepeatedAmountPattern(int $customerId, float $amount): bool
    {
        $count = Transaction::where('customer_id', $customerId)
            ->where('amount', $amount)
            ->where('created_at', '>=', now()->subHours(2))
            ->count();

        return $count > 3;
    }

    /**
     * Evaluate a payment attempt and update its status based on the risk score.
     * Returns the new status enum instance.
     */
    public function evaluatePaymentAttempt(\App\Models\PaymentAttempt $attempt): \App\Enums\PaymentAttemptStatus
    {
        $result = $this->calculateRiskScore($attempt->transaction);
        switch ($result['action']) {
            case 'block':
                $attempt->status = \App\Enums\PaymentAttemptStatus::FLAGGED_FRAUD->value;
                break;
            case 'review':
            case 'challenge':
                $attempt->status = \App\Enums\PaymentAttemptStatus::PENDING->value;
                break;
            default:
                $attempt->status = \App\Enums\PaymentAttemptStatus::INITIATED->value;
        }

        $attempt->save();

        return \App\Enums\PaymentAttemptStatus::from($attempt->status);
    }
}