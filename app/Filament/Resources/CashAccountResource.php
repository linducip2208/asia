<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashAccountResource\Pages;
use App\Models\CashAccount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CashAccountResource extends Resource
{
    protected static ?string $model = CashAccount::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static string|\UnitEnum|null $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Kas & Bank';
    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Akun')->schema([
                \Filament\Schemas\Components\TextInput::make('name')->label('Nama Akun')->required()->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('code')->label('Kode')->maxLength(20),
                \Filament\Schemas\Components\Select::make('type')->label('Tipe')->options(['cash' => 'Kas', 'bank' => 'Bank', 'ewallet' => 'E-Wallet'])->required(),
                \Filament\Schemas\Components\Select::make('outlet_id')->label('Outlet')->relationship('outlet', 'name')->nullable(),
                \Filament\Schemas\Components\TextInput::make('bank_name')->label('Nama Bank')->nullable(),
                \Filament\Schemas\Components\TextInput::make('account_number')->label('No. Rekening')->nullable(),
                \Filament\Schemas\Components\TextInput::make('account_holder')->label('Atas Nama')->nullable(),
                \Filament\Schemas\Components\TextInput::make('opening_balance')->label('Saldo Awal')->numeric()->default(0),
                \Filament\Schemas\Components\TextInput::make('current_balance')->label('Saldo Saat Ini')->numeric()->disabled(),
                \Filament\Schemas\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                \Filament\Schemas\Components\Toggle::make('is_default')->label('Default')->default(false),
                \Filament\Schemas\Components\Textarea::make('notes')->label('Catatan')->rows(2),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Akun')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
            Tables\Columns\TextColumn::make('bank_name')->label('Bank'),
            Tables\Columns\TextColumn::make('account_number')->label('No. Rekening'),
            Tables\Columns\TextColumn::make('current_balance')->label('Saldo')->money('IDR'),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashAccounts::route('/'),
            'create' => Pages\CreateCashAccount::route('/create'),
            'edit' => Pages\EditCashAccount::route('/{record}/edit'),
        ];
    }
}
