<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChartOfAccountResource\Pages;
use App\Models\ChartOfAccount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ChartOfAccountResource extends Resource
{
    protected static ?string $model = ChartOfAccount::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected static string|\UnitEnum|null $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Chart of Accounts';
    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Akun')->schema([
                \Filament\Schemas\Components\Select::make('parent_id')->label('Induk')->relationship('parent', 'name', fn($q) => $q->where('level', '<', 3))->searchable()->nullable(),
                \Filament\Schemas\Components\TextInput::make('code')->label('Kode Akun')->required()->maxLength(20),
                \Filament\Schemas\Components\TextInput::make('name')->label('Nama Akun')->required()->maxLength(255),
                \Filament\Schemas\Components\Select::make('type')->label('Tipe')->options([
                    'asset' => 'Aset', 'liability' => 'Kewajiban', 'equity' => 'Ekuitas', 'revenue' => 'Pendapatan', 'expense' => 'Beban',
                ])->required(),
                \Filament\Schemas\Components\Select::make('normal_balance')->label('Saldo Normal')->options(['debit' => 'Debit', 'credit' => 'Kredit'])->default('debit'),
                \Filament\Schemas\Components\TextInput::make('opening_balance')->label('Saldo Awal')->numeric(),
                \Filament\Schemas\Components\Textarea::make('description')->label('Deskripsi')->rows(2),
                \Filament\Schemas\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('code')->label('Kode')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('name')->label('Nama Akun')->searchable(),
            Tables\Columns\TextColumn::make('type')->label('Tipe')->badge()->colors([
                'info' => 'asset', 'warning' => 'liability', 'success' => 'equity', 'primary' => 'revenue', 'danger' => 'expense',
            ]),
            Tables\Columns\TextColumn::make('current_balance')->label('Saldo')->money('IDR'),
            Tables\Columns\TextColumn::make('normal_balance')->label('Normal'),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChartOfAccounts::route('/'),
            'create' => Pages\CreateChartOfAccount::route('/create'),
            'edit' => Pages\EditChartOfAccount::route('/{record}/edit'),
        ];
    }
}
