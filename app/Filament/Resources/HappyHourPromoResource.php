<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HappyHourPromoResource\Pages;
use App\Models\HappyHourPromo;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class HappyHourPromoResource extends Resource
{
    protected static ?string $model = HappyHourPromo::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static string|\UnitEnum|null $navigationGroup = '🎁 Promo';
    protected static ?string $navigationLabel = 'Happy Hour';
    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Happy Hour')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Promo')->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\Select::make('day_of_week')->label('Hari')->options([
                    'all' => 'Setiap Hari',
                    'monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu',
                    'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu',
                ])->default('all')->required(),
                Forms\Components\TimePicker::make('start_time')->label('Jam Mulai')->seconds(false)->required(),
                Forms\Components\TimePicker::make('end_time')->label('Jam Selesai')->seconds(false)->required(),
            ])->columns(2),
            Section::make('Pengaturan Diskon')->schema([
                Forms\Components\TextInput::make('discount_percent')->label('Diskon (%)')->numeric()->required(),
                Forms\Components\TextInput::make('max_discount_amount')->label('Maks Diskon (Rp)')->numeric()->prefix('Rp')->nullable(),
                Forms\Components\TextInput::make('min_purchase_amount')->label('Min Pembelian (Rp)')->numeric()->prefix('Rp')->default(0),
            ])->columns(3),
            Section::make('Batasan Produk & Kategori')->schema([
                Forms\Components\Select::make('applicable_category_ids')->label('Kategori Berlaku')->multiple()->options(fn () => \App\Models\Category::pluck('name', 'id'))->searchable(),
                Forms\Components\Select::make('applicable_product_ids')->label('Produk Berlaku')->multiple()->options(fn () => \App\Models\Product::pluck('name', 'id'))->searchable(),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\Toggle::make('is_stackable')->label('Dapat Digabung'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama Promo')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('day_of_week')->label('Hari')->badge(),
            Tables\Columns\TextColumn::make('start_time')->label('Mulai')->time('H:i'),
            Tables\Columns\TextColumn::make('end_time')->label('Selesai')->time('H:i'),
            Tables\Columns\TextColumn::make('discount_percent')->label('Diskon')->suffix('%')->sortable(),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->filters([
            Tables\Filters\TernaryFilter::make('is_active')->label('Status Aktif'),
        ])->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHappyHourPromos::route('/'),
            'create' => Pages\CreateHappyHourPromo::route('/create'),
            'edit' => Pages\EditHappyHourPromo::route('/{record}/edit'),
        ];
    }
}
