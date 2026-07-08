<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Models\Warehouse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office';
    protected static string|\UnitEnum|null $navigationGroup = '📦 Inventory';
    protected static ?string $navigationLabel = 'Gudang';
    protected static ?int $navigationSort = 70;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Gudang')->schema([
                \Filament\Schemas\Components\TextInput::make('name')->label('Nama Gudang')->required()->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('code')->label('Kode')->maxLength(20),
                \Filament\Schemas\Components\Select::make('outlet_id')->label('Outlet')->relationship('outlet', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('type')->label('Tipe')->options([
                    'main' => 'Utama','satellite' => 'Satelit','transit' => 'Transit','returns' => 'Retur',
                ])->default('main'),
                \Filament\Schemas\Components\Textarea::make('address')->label('Alamat')->rows(2),
                \Filament\Schemas\Components\TextInput::make('capacity')->label('Kapasitas')->numeric()->suffix('unit'),
                \Filament\Schemas\Components\TextInput::make('manager_name')->label('Nama Pengelola'),
                \Filament\Schemas\Components\TextInput::make('manager_phone')->label('Telepon Pengelola'),
                \Filament\Schemas\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('code')->label('Kode')->searchable(),
            Tables\Columns\TextColumn::make('outlet.name')->label('Outlet'),
            Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            Tables\Columns\TextColumn::make('manager_name')->label('Pengelola'),
        ])->filters([
            Tables\Filters\SelectFilter::make('type'),
            Tables\Filters\SelectFilter::make('outlet_id')->relationship('outlet','name'),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
