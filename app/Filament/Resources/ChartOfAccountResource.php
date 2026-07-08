<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChartOfAccountResource\Pages;
use App\Models\ChartOfAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChartOfAccountResource extends Resource
{
    protected static ?string $model = ChartOfAccount::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Chart of Accounts';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Akun')->schema([
                Forms\Components\Select::make('parent_id')->label('Induk')->relationship('parent', 'name', fn($q) => $q->where('level', '<', 3))->searchable()->nullable(),
                Forms\Components\TextInput::make('code')->label('Kode Akun')->required()->maxLength(20),
                Forms\Components\TextInput::make('name')->label('Nama Akun')->required()->maxLength(255),
                Forms\Components\Select::make('type')->label('Tipe')->options([
                    'asset' => 'Aset', 'liability' => 'Kewajiban', 'equity' => 'Ekuitas', 'revenue' => 'Pendapatan', 'expense' => 'Beban',
                ])->required(),
                Forms\Components\Select::make('normal_balance')->label('Saldo Normal')->options(['debit' => 'Debit', 'credit' => 'Kredit'])->default('debit'),
                Forms\Components\TextInput::make('opening_balance')->label('Saldo Awal')->numeric(),
                Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('code')->label('Kode')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('name')->label('Nama Akun')->searchable(),
            Tables\Columns\BadgeColumn::make('type')->label('Tipe')->colors([
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
