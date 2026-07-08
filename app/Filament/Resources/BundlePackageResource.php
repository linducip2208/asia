<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BundlePackageResource\Pages;
use App\Models\BundlePackage;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BundlePackageResource extends Resource
{
    protected static ?string $model = BundlePackage::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cube';
    protected static string|\UnitEnum|null $navigationGroup = '🎁 Promo';
    protected static ?string $navigationLabel = 'Bundle / Paket';
    protected static ?int $navigationSort = 60;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Bundle')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Bundle')->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\TextInput::make('bundle_price')->label('Harga Bundle (Rp)')->numeric()->prefix('Rp')->required(),
                Forms\Components\TextInput::make('original_price')->label('Harga Normal (Rp)')->numeric()->prefix('Rp')->default(0),
                Forms\Components\DatePicker::make('valid_from')->label('Berlaku Dari'),
                Forms\Components\DatePicker::make('valid_until')->label('Berlaku Sampai'),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ])->columns(2),
            Section::make('Item Bundle')->schema([
                Forms\Components\Repeater::make('items')->label('Produk dalam Bundle')->relationship()->schema([
                    Forms\Components\Select::make('product_id')->label('Produk')->relationship('product', 'name')->searchable()->preload()->required(),
                    Forms\Components\TextInput::make('quantity')->label('Jumlah')->numeric()->default(1)->required(),
                ])->columns(2)->defaultItems(1)->addActionLabel('Tambah Produk')->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama Bundle')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('bundle_price')->label('Harga Bundle')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('original_price')->label('Harga Normal')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('items_count')->label('Jumlah Item')->counts('items')->badge(),
            Tables\Columns\TextColumn::make('valid_until')->label('Sampai')->date()->sortable(),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->filters([
            Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
        ])->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBundlePackages::route('/'),
            'create' => Pages\CreateBundlePackage::route('/create'),
            'edit' => Pages\EditBundlePackage::route('/{record}/edit'),
        ];
    }
}
