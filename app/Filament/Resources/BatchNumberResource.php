<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BatchNumberResource\Pages;
use App\Models\BatchNumber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BatchNumberResource extends Resource
{
    protected static ?string $model = BatchNumber::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static string|\UnitEnum|null $navigationGroup = '📦 Inventory';
    protected static ?string $navigationLabel = 'Batch Number';
    protected static ?int $navigationSort = 80;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Batch')->schema([
                \Filament\Schemas\Components\Select::make('product_id')->label('Produk')->relationship('product', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('warehouse_id')->label('Gudang')->relationship('warehouse', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\TextInput::make('batch_number')->label('No. Batch')->maxLength(255),
                \Filament\Schemas\Components\DatePicker::make('production_date')->label('Tanggal Produksi'),
                \Filament\Schemas\Components\DatePicker::make('expiry_date')->label('Tanggal Kadaluarsa'),
                \Filament\Schemas\Components\TextInput::make('initial_quantity')->label('Qty Awal')->numeric(),
                \Filament\Schemas\Components\TextInput::make('current_quantity')->label('Qty Saat Ini')->numeric()->disabled(),
                \Filament\Schemas\Components\TextInput::make('cost_price')->label('Harga Pokok')->numeric(),
                \Filament\Schemas\Components\Select::make('purchase_order_id')->label('Purchase Order')->relationship('purchaseOrder', 'po_number')->searchable()->preload(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('batch_number')->label('No. Batch')->searchable(),
            Tables\Columns\TextColumn::make('product.name')->label('Produk')->searchable(),
            Tables\Columns\TextColumn::make('warehouse.name')->label('Gudang'),
            Tables\Columns\TextColumn::make('expiry_date')->label('Kadaluarsa')->date('d M Y'),
            Tables\Columns\TextColumn::make('initial_quantity')->label('Qty Awal')->numeric(),
            Tables\Columns\TextColumn::make('current_quantity')->label('Qty Saat Ini')->numeric(),
        ])->filters([Tables\Filters\SelectFilter::make('warehouse_id')->relationship('warehouse', 'name')])
          ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatchNumbers::route('/'),
            'create' => Pages\CreateBatchNumber::route('/create'),
            'edit' => Pages\EditBatchNumber::route('/{record}/edit'),
        ];
    }
}
