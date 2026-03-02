<?php

namespace App\Enums;

enum PaymentMethodType: string
{
    case CARD_READER = 'card-reader';
    case ESEWA = 'esewa';
    case KHALTI = 'khalti';
    case BANK_TRANSFER = 'bank-transfer';
}
