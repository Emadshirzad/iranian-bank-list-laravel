<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IranianBankResource\Pages;
use App\Filament\Resources\IranianBankResource\RelationManagers;
use App\Models\IranianBank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IranianBankResource extends Resource
{
    protected static ?string $model = IranianBank::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('bank_logo')
                    ->label('Bank Image')
                    ->size(50)
                    ->circular()
                    ->defaultImageUrl(asset('vendor/iranian-bank/images/bank/default.png'))
                    ->getStateUsing(function ($record) {
                        return asset($record->bank_logo);
                    }),
                Tables\Columns\TextColumn::make('bank_title')
                    ->label('Bank Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Bank Name (EN)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('card_no')
                    ->label('Card Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('iban')
                    ->label('IBAN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('card_regex')
                    ->label('Card Regex')
                    ->searchable(),
                Tables\Columns\TextColumn::make('iban_regex')
                    ->label('IBAN Regex')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListIranianBanks::route('/'),
        ];
    }
}
