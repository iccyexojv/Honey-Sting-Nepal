<?php

namespace App\Filament\Admin\Resources\Cards\Schemas;

use App\Enums\CardStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('physical_id')
                    ->required(),
                TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(CardStatus::class)
                    ->required(),
            ]);
    }
}
