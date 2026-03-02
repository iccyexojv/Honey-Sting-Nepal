<?php

namespace App\Filament\Merchant\Resources\Transactions\Pages;

use App\Filament\Merchant\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
