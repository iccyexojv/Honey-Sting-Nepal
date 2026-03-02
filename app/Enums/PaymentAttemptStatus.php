<?php

namespace App\Enums;

enum PaymentAttemptStatus: string
{
    case INITIATED = 'initiated';
    case PENDING = 'pending';
    case FAILED = 'failed';
    case SUCCESSFUL = 'successful';
    case FLAGGED_FRAUD = 'flagged_fraud';
}
