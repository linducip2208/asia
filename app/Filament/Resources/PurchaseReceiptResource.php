<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseReceiptResource\Pages;
use App\Models\PurchaseReceipt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseReceiptResource extends Resource
{
    protected static ?string $model = PurchaseReceipt::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static string|\UnitEnum|null $navigationGroup = '🛒 Pembelian';
    protected static ?string $navigationLabel = 'Penerimaan Barang';
    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Penerimaan')->schema([
                \Filament\Schemas\Components\TextInput::make('receipt_number')->label('No. Penerimaan')->disabled()->default(fn() => 'QT-'.date('Ymd').'-'.strtoupper(substr(uniqid(),-6))),
                \Filament\Schemas\Components\Select::make('purchase_order_id')->label('Purchase Order')->relationship('purchaseOrder', 'po_number')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('supplier_id')->label('Supplier')->relationship('supplier', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('warehouse_id')->label('Gudang')->relationship('warehouse', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\DatePicker::make('receipt_date')->label('Tanggal Terima'),
                \Filament\Schemas\Components\TextInput::make('supplier_invoice_number')->label('No. Invoice Supplier')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('total_amount')->label('Total')->numeric()->disabled(),
                \Filament\Schemas\Components\Select::make('status')->label('Status')->options([
                    'draft' => 'Draft','completed' => 'Selesai',
                ])->default('draft'),
                \Filament\Schemas\Components\Textarea::make('notes')->label('Catatan')->rows(3),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('receipt_number')->label('No.')->searchable(),
            Tables\Columns\TextColumn::make('supplier.name')->label('Supplier')->searchable(),
            Tables\Columns\TextColumn::make('purchaseOrder.po_number')->label('PO')->searchable(),
            Tables\Columns\TextColumn::make('warehouse.name')->label('Gudang'),
            Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR'),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge()->colors([
                'gray' => 'draft','success' => 'completed',
            ]),
            Tables\Columns\TextColumn::make('receipt_date')->label('Tanggal')->date('d M Y'),
        ])->filters([Tables\Filters\SelectFilter::make('status')])
          ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseReceipts::route('/'),
            'create' => Pages\CreatePurchaseReceipt::route('/create'),
            'edit' => Pages\EditPurchaseReceipt::route('/{record}/edit'),
        ];
    }
}
