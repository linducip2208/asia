<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseEntryResource\Pages;
use App\Models\ExpenseEntry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseEntryResource extends Resource
{
    protected static ?string $model = ExpenseEntry::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-circle';
    protected static string|\UnitEnum|null $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Pengeluaran';
    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Pengeluaran')->schema([
                \Filament\Schemas\Components\TextInput::make('expense_number')->label('No. Pengeluaran')->disabled()->default(fn() => 'EX-'.date('Ymd').'-'.strtoupper(substr(uniqid(),-6))),
                \Filament\Schemas\Components\Select::make('cash_account_id')->label('Akun Kas')->relationship('cashAccount', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('chart_of_account_id')->label('Akun COA')->relationship('chartOfAccount', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\DatePicker::make('transaction_date')->label('Tanggal Transaksi'),
                \Filament\Schemas\Components\TextInput::make('amount')->label('Jumlah')->numeric(),
                \Filament\Schemas\Components\Select::make('category')->label('Kategori')->options([
                    'salary' => 'Gaji','rent' => 'Sewa','utility' => 'Utilitas','marketing' => 'Marketing','maintenance' => 'Pemeliharaan','other' => 'Lainnya',
                ]),
                \Filament\Schemas\Components\TextInput::make('payment_method')->label('Metode Pembayaran')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('recipient')->label('Penerima')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('reference_number')->label('No. Referensi')->maxLength(255),
                \Filament\Schemas\Components\Textarea::make('description')->label('Deskripsi')->rows(3),
                \Filament\Schemas\Components\TextInput::make('attachment')->label('Lampiran')->maxLength(255),
                \Filament\Schemas\Components\Select::make('status')->label('Status')->options([
                    'draft' => 'Draft','approved' => 'Disetujui','paid' => 'Dibayar',
                ])->default('draft'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('expense_number')->label('No.')->searchable(),
            Tables\Columns\TextColumn::make('cashAccount.name')->label('Akun Kas'),
            Tables\Columns\TextColumn::make('category')->label('Kategori')->badge(),
            Tables\Columns\TextColumn::make('amount')->label('Jumlah')->money('IDR'),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge()->colors([
                'gray' => 'draft','warning' => 'approved','success' => 'paid',
            ]),
            Tables\Columns\TextColumn::make('transaction_date')->label('Tanggal')->date('d M Y'),
        ])->filters([Tables\Filters\SelectFilter::make('category'), Tables\Filters\SelectFilter::make('status')])
          ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpenseEntries::route('/'),
            'create' => Pages\CreateExpenseEntry::route('/create'),
            'edit' => Pages\EditExpenseEntry::route('/{record}/edit'),
        ];
    }
}
