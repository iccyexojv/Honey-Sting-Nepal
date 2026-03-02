<?php

namespace App\Filament\Consumer\Resources\Transactions\Pages;

use App\Filament\Consumer\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
