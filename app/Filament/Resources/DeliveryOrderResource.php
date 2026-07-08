<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryOrderResource\Pages;
use App\Models\DeliveryOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class DeliveryOrderResource extends Resource
{
    protected static ?string $model = DeliveryOrder::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static string|\UnitEnum|null $navigationGroup = '💰 Penjualan';
    protected static ?string $navigationLabel = 'Delivery Order';
    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Delivery Order')->schema([
                \Filament\Schemas\Components\TextInput::make('do_number')->label('No. DO')->disabled()->default(fn() => 'DO-'.date('Ymd').'-'.strtoupper(substr(uniqid(),-6))),
                \Filament\Schemas\Components\Select::make('order_id')->label('Order')->relationship('order', 'order_number')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('customer_id')->label('Customer')->relationship('customer', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\TextInput::make('recipient_name')->label('Nama Penerima')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('recipient_phone')->label('Telepon Penerima')->maxLength(255),
                \Filament\Schemas\Components\Textarea::make('shipping_address')->label('Alamat Pengiriman')->rows(3),
                \Filament\Schemas\Components\TextInput::make('courier')->label('Kurir')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('tracking_number')->label('No. Resi')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('shipping_cost')->label('Biaya Kirim')->numeric(),
                \Filament\Schemas\Components\Select::make('status')->label('Status')->options([
                    'pending' => 'Pending','packed' => 'Dikemas','shipped' => 'Dikirim','delivered' => 'Terkirim','failed' => 'Gagal',
                ])->default('pending'),
                \Filament\Schemas\Components\Textarea::make('notes')->label('Catatan')->rows(3),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('do_number')->label('No.')->searchable(),
            Tables\Columns\TextColumn::make('order.order_number')->label('Order')->searchable(),
            Tables\Columns\TextColumn::make('customer.name')->label('Customer')->searchable(),
            Tables\Columns\TextColumn::make('courier')->label('Kurir'),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge()->colors([
                'gray' => 'pending','warning' => 'packed','info' => 'shipped','success' => 'delivered','danger' => 'failed',
            ]),
            Tables\Columns\TextColumn::make('shipped_at')->label('Dikirim')->dateTime('d M Y'),
        ])->filters([Tables\Filters\SelectFilter::make('status')])
          ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryOrders::route('/'),
            'create' => Pages\CreateDeliveryOrder::route('/create'),
            'edit' => Pages\EditDeliveryOrder::route('/{record}/edit'),
        ];
    }
}
