<?php

namespace App\Models;

use App\Enums\TransasctionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    // Allow these fields to be saved to the database
    protected $fillable = [
        'customer_id',
        'merchant_id',
        'card_id',
        'payment_method_id',
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

    /**
     * Relationship: This transaction uses a Card
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Relationship: This transaction uses a PaymentMethod
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentAttempts(): HasMany
    {
        return $this->hasMany(PaymentAttempt::class);
    }
}
