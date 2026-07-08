<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = '📦 Inventory';
    protected static ?string $navigationLabel = 'Gudang';
    protected static ?int $navigationSort = 70;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Gudang')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Gudang')->required()->maxLength(255),
                Forms\Components\TextInput::make('code')->label('Kode')->maxLength(20),
                Forms\Components\Select::make('outlet_id')->label('Outlet')->relationship('outlet', 'name')->searchable()->preload(),
                Forms\Components\Select::make('type')->label('Tipe')->options([
                    'main' => 'Utama', 'satellite' => 'Satelit', 'transit' => 'Transit', 'returns' => 'Retur',
                ])->default('main'),
                Forms\Components\Textarea::make('address')->label('Alamat')->rows(2),
                Forms\Components\TextInput::make('capacity')->label('Kapasitas')->numeric()->suffix('unit'),
                Forms\Components\TextInput::make('manager_name')->label('Nama Pengelola'),
                Forms\Components\TextInput::make('manager_phone')->label('Telepon Pengelola'),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('code')->label('Kode')->searchable(),
            Tables\Columns\TextColumn::make('outlet.name')->label('Outlet'),
            Tables\Columns\BadgeColumn::make('type')->label('Tipe'),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            Tables\Columns\TextColumn::make('manager_name')->label('Pengelola'),
        ])->filters([
            Tables\Filters\SelectFilter::make('type'),
            Tables\Filters\SelectFilter::make('outlet_id')->relationship('outlet', 'name'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
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
