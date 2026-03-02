<?php

namespace App\Filament\Admin\Resources\Transactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;

class TransactionForm
{
    // The parameter type might be 'Schema $schema' or 'Form $form' depending on your setup.
    public static function configure($schema) 
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Buyer (User)')
                    ->searchable()
                    ->required(),
                Select::make('merchant_id')
                    // Custom query to only show merchants
                    ->relationship('merchant', 'name', fn (Builder $query) => $query->where('role', 'merchant'))
                    ->label('Seller (Merchant)')
                    ->searchable()
                    ->required(),
                TextInput::make('amount')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->minValue(0),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])
                    ->required()
                    ->default('pending'),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}