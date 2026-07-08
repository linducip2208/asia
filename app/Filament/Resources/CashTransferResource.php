<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashTransferResource\Pages;
use App\Models\CashTransfer;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CashTransferResource extends Resource
{
    protected static ?string $model = CashTransfer::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static string|\UnitEnum|null $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Transfer Kas';
    protected static ?int $navigationSort = 60;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Transfer')->schema([
                Forms\Components\TextInput::make('transfer_number')->label('No. Transfer')->disabled()->dehydrated(false)->placeholder('Otomatis'),
                Forms\Components\Select::make('from_cash_account_id')->label('Dari Akun')->relationship('fromAccount', 'name')->searchable()->preload()->required(),
                Forms\Components\Select::make('to_cash_account_id')->label('Ke Akun')->relationship('toAccount', 'name')->searchable()->preload()->required(),
                Forms\Components\DatePicker::make('transfer_date')->label('Tanggal Transfer')->default(now())->required(),
                Forms\Components\TextInput::make('amount')->label('Jumlah')->numeric()->prefix('Rp')->required(),
                Forms\Components\TextInput::make('fee')->label('Biaya Admin')->numeric()->prefix('Rp')->default(0),
                Forms\Components\TextInput::make('reference_number')->label('No. Referensi')->maxLength(255),
                Forms\Components\Textarea::make('notes')->label('Catatan')->rows(2)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('transfer_number')->label('No. Transfer')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('fromAccount.name')->label('Dari')->searchable(),
            Tables\Columns\TextColumn::make('toAccount.name')->label('Ke')->searchable(),
            Tables\Columns\TextColumn::make('amount')->label('Jumlah')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('fee')->label('Biaya')->money('IDR')->toggleable(),
            Tables\Columns\TextColumn::make('transfer_date')->label('Tanggal')->date('d/m/Y')->sortable(),
        ])->defaultSort('transfer_date', 'desc')->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashTransfers::route('/'),
            'create' => Pages\CreateCashTransfer::route('/create'),
            'edit' => Pages\EditCashTransfer::route('/{record}/edit'),
        ];
    }
}
