<?php

namespace App\Filament\Admin\Resources\PaymentMethods\Schemas;

use App\Enums\PaymentMethodStatus;
use App\Enums\PaymentMethodType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('merchant_id')
                    ->relationship('merchant', 'name')
                    ->required(),
                TextInput::make('nickname'),
                Select::make('type')
                    ->options(PaymentMethodType::class)
                    ->required(),
                Select::make('status')
                    ->options(PaymentMethodStatus::class)
                    ->required(),
                Textarea::make('config')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
