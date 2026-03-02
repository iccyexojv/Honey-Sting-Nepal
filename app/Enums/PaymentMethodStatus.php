<?php

namespace App\Enums;

enum PaymentMethodStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case FLAGGED_FRAUD = 'flagged_fraud';
}
