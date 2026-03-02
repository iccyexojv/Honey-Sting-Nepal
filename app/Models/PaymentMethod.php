<?php

namespace App\Models;

use App\Enums\PaymentMethodStatus;
use App\Enums\PaymentMethodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'merchant_id',
        'nickname',
        'type',
        'status',
        'config',
    ];

    protected $hidden = [
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
