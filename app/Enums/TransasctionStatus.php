<?php

namespace App\Enums;

enum TransasctionStatus: string
{
    case PENDING = 'pending';
    case COMPLETE = 'complete';
    case CANCELLED = 'cancelled';
    case FAILED = 'failed';
}
