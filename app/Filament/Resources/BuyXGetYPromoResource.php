<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BuyXGetYPromoResource\Pages;
use App\Models\BuyXGetYPromo;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BuyXGetYPromoResource extends Resource
{
    protected static ?string $model = BuyXGetYPromo::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static string|\UnitEnum|null $navigationGroup = '🎁 Promo';
    protected static ?string $navigationLabel = 'Buy X Get Y';
    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Promo')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Promo')->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\Select::make('buy_product_id')->label('Produk Beli (X)')->relationship('buyProduct', 'name')->searchable()->preload()->nullable(),
                Forms\Components\TextInput::make('buy_quantity')->label('Jumlah Beli')->numeric()->required()->default(1),
                Forms\Components\Select::make('get_product_id')->label('Produk Gratis (Y)')->relationship('getProduct', 'name')->searchable()->preload()->nullable(),
                Forms\Components\TextInput::make('get_quantity')->label('Jumlah Dapat')->numeric()->required()->default(1),
            ])->columns(2),
            Section::make('Pengaturan Diskon')->schema([
                Forms\Components\Select::make('discount_type')->label('Tipe Diskon')->options(['free' => 'Gratis', 'percent' => 'Persentase'])->default('free')->required(),
                Forms\Components\TextInput::make('discount_value')->label('Nilai Diskon (%)')->numeric()->default(100),
                Forms\Components\Toggle::make('apply_to_same_product')->label('Berlaku Produk Sama'),
                Forms\Components\TextInput::make('max_usage_per_transaction')->label('Maks per Transaksi')->numeric()->default(1),
                Forms\Components\TextInput::make('total_usage_limit')->label('Batas Total Penggunaan')->numeric()->nullable(),
            ])->columns(2),
            Section::make('Masa Berlaku')->schema([
                Forms\Components\DatePicker::make('valid_from')->label('Berlaku Dari'),
                Forms\Components\DatePicker::make('valid_until')->label('Berlaku Sampai'),
                Forms\Components\Select::make('applicable_outlet_ids')->label('Outlet Berlaku')->multiple()->options(fn () => \App\Models\Outlet::pluck('name', 'id'))->searchable(),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\Toggle::make('is_stackable')->label('Dapat Digabung'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama Promo')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('buyProduct.name')->label('Beli')->searchable(),
            Tables\Columns\TextColumn::make('buy_quantity')->label('Qty X')->numeric(),
            Tables\Columns\TextColumn::make('getProduct.name')->label('Dapat')->searchable(),
            Tables\Columns\TextColumn::make('get_quantity')->label('Qty Y')->numeric(),
            Tables\Columns\TextColumn::make('discount_type')->label('Tipe')->badge(),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->filters([
            Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
        ])->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBuyXGetYPromos::route('/'),
            'create' => Pages\CreateBuyXGetYPromo::route('/create'),
            'edit' => Pages\EditBuyXGetYPromo::route('/{record}/edit'),
        ];
    }
}
