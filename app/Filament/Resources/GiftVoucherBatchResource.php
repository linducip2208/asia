<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftVoucherBatchResource\Pages;
use App\Models\GiftVoucherBatch;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GiftVoucherBatchResource extends Resource
{
    protected static ?string $model = GiftVoucherBatch::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-gift';
    protected static string|\UnitEnum|null $navigationGroup = '🎁 Promo';
    protected static ?string $navigationLabel = 'Gift Voucher';
    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Batch Gift Voucher')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Batch')->required()->maxLength(255),
                Forms\Components\TextInput::make('prefix')->label('Prefix Kode')->default('VCR')->required()->maxLength(10),
                Forms\Components\TextInput::make('quantity')->label('Jumlah Voucher')->numeric()->minValue(1)->required(),
                Forms\Components\Select::make('type')->label('Tipe')->options(['fixed' => 'Nominal Tetap', 'percent' => 'Persentase'])->default('fixed')->required(),
                Forms\Components\TextInput::make('value')->label('Nilai')->numeric()->required(),
                Forms\Components\TextInput::make('min_purchase')->label('Min. Pembelian')->numeric()->prefix('Rp')->default(0),
                Forms\Components\DatePicker::make('valid_from')->label('Berlaku Dari'),
                Forms\Components\DatePicker::make('valid_until')->label('Berlaku Sampai'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama Batch')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('prefix')->label('Prefix'),
            Tables\Columns\TextColumn::make('quantity')->label('Jumlah')->sortable(),
            Tables\Columns\TextColumn::make('value')->label('Nilai')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('valid_from')->label('Dari')->date('d/m/Y'),
            Tables\Columns\TextColumn::make('valid_until')->label('Sampai')->date('d/m/Y'),
        ])->defaultSort('created_at', 'desc')->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGiftVoucherBatches::route('/'),
            'create' => Pages\CreateGiftVoucherBatch::route('/create'),
            'edit' => Pages\EditGiftVoucherBatch::route('/{record}/edit'),
        ];
    }
}
