<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Filament\Resources\QuotationResource\RelationManagers;
use App\Models\Quotation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = '💰 Penjualan';
    protected static ?string $navigationLabel = 'Quotation';
    protected static ?int $navigationSort = 40;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Quotation')->schema([
                Forms\Components\TextInput::make('quotation_number')
                    ->label('No. Quotation')
                    ->disabled()
                    ->default(fn () => 'QT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6))),
                Forms\Components\Select::make('customer_id')->label('Customer')->relationship('customer', 'name')->searchable()->preload(),
                Forms\Components\Select::make('outlet_id')->label('Outlet')->relationship('outlet', 'name')->required(),
                Forms\Components\Select::make('status')->label('Status')->options([
                    'draft' => 'Draft', 'sent' => 'Terkirim', 'accepted' => 'Diterima',
                    'rejected' => 'Ditolak', 'converted' => 'Converted', 'expired' => 'Expired',
                ])->default('draft'),
                Forms\Components\DatePicker::make('valid_until')->label('Berlaku Sampai'),
                Forms\Components\Textarea::make('notes')->label('Catatan')->rows(3),
                Forms\Components\Textarea::make('terms_conditions')->label('Syarat & Ketentuan')->rows(3),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('quotation_number')->label('No.')->searchable(),
            Tables\Columns\TextColumn::make('customer.name')->label('Customer')->searchable(),
            Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR'),
            Tables\Columns\BadgeColumn::make('status')->label('Status')->colors([
                'gray' => 'draft', 'warning' => 'sent', 'success' => 'accepted',
                'danger' => 'rejected', 'info' => 'converted', 'gray' => 'expired',
            ]),
            Tables\Columns\TextColumn::make('valid_until')->label('Valid Sampai')->date('d M Y'),
            Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y'),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('convert')->label('Jadi Order')->icon('heroicon-o-arrow-path')->color('success'),
        ]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }
}
