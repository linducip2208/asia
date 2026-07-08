<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeEntryResource\Pages;
use App\Models\IncomeEntry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class IncomeEntryResource extends Resource
{
    protected static ?string $model = IncomeEntry::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-up-circle';
    protected static string|\UnitEnum|null $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Pemasukan';
    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Pemasukan')->schema([
                \Filament\Schemas\Components\TextInput::make('income_number')->label('No. Pemasukan')->disabled()->default(fn() => 'IN-'.date('Ymd').'-'.strtoupper(substr(uniqid(),-6))),
                \Filament\Schemas\Components\Select::make('cash_account_id')->label('Akun Kas')->relationship('cashAccount', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('chart_of_account_id')->label('Akun COA')->relationship('chartOfAccount', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\DatePicker::make('transaction_date')->label('Tanggal Transaksi'),
                \Filament\Schemas\Components\TextInput::make('amount')->label('Jumlah')->numeric(),
                \Filament\Schemas\Components\Select::make('source')->label('Sumber')->options([
                    'sales' => 'Penjualan','other_income' => 'Pendapatan Lain','receivable_collection' => 'Penagihan Piutang','owner_deposit' => 'Setoran Pemilik',
                ]),
                \Filament\Schemas\Components\TextInput::make('payment_method')->label('Metode Pembayaran')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('reference_number')->label('No. Referensi')->maxLength(255),
                \Filament\Schemas\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('income_number')->label('No.')->searchable(),
            Tables\Columns\TextColumn::make('cashAccount.name')->label('Akun Kas'),
            Tables\Columns\TextColumn::make('amount')->label('Jumlah')->money('IDR'),
            Tables\Columns\TextColumn::make('source')->label('Sumber')->badge(),
            Tables\Columns\TextColumn::make('transaction_date')->label('Tanggal')->date('d M Y'),
        ])->filters([Tables\Filters\SelectFilter::make('source')])
          ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomeEntries::route('/'),
            'create' => Pages\CreateIncomeEntry::route('/create'),
            'edit' => Pages\EditIncomeEntry::route('/{record}/edit'),
        ];
    }
}
