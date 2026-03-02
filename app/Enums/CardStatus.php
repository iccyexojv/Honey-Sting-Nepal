<?php

namespace App\Enums;

enum CardStatus: string
{
    case ACTIVE = 'active';
    case DISABLED = 'disabled';
    case FLAGGED_FRAUD = 'flagged_fraud';
}
