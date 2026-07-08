<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockAdjustmentResource\Pages;
use App\Models\StockAdjustment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class StockAdjustmentResource extends Resource
{
    protected static ?string $model = StockAdjustment::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-up-down';
    protected static string|\UnitEnum|null $navigationGroup = '📦 Inventory';
    protected static ?string $navigationLabel = 'Penyesuaian Stok';
    protected static ?int $navigationSort = 90;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Penyesuaian')->schema([
                \Filament\Schemas\Components\TextInput::make('adjustment_number')->label('No. Penyesuaian')->disabled()->default(fn() => 'ADJ-'.date('Ymd').'-'.strtoupper(substr(uniqid(),-6))),
                \Filament\Schemas\Components\Select::make('outlet_id')->label('Outlet')->relationship('outlet', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('warehouse_id')->label('Gudang')->relationship('warehouse', 'name')->searchable()->preload(),
                \Filament\Schemas\Components\Select::make('type')->label('Tipe')->options([
                    'addition' => 'Penambahan','subtraction' => 'Pengurangan',
                ]),
                \Filament\Schemas\Components\TextInput::make('reason')->label('Alasan')->maxLength(255),
                \Filament\Schemas\Components\Textarea::make('notes')->label('Catatan')->rows(3),
                \Filament\Schemas\Components\Select::make('status')->label('Status')->options([
                    'draft' => 'Draft','approved' => 'Disetujui','completed' => 'Selesai',
                ])->default('draft'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('adjustment_number')->label('No.')->searchable(),
            Tables\Columns\TextColumn::make('outlet.name')->label('Outlet'),
            Tables\Columns\TextColumn::make('warehouse.name')->label('Gudang'),
            Tables\Columns\TextColumn::make('type')->label('Tipe')->badge()->colors([
                'success' => 'addition','danger' => 'subtraction',
            ]),
            Tables\Columns\TextColumn::make('reason')->label('Alasan')->searchable(),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge()->colors([
                'gray' => 'draft','warning' => 'approved','success' => 'completed',
            ]),
            Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y'),
        ])->filters([Tables\Filters\SelectFilter::make('type'), Tables\Filters\SelectFilter::make('status')])
          ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockAdjustments::route('/'),
            'create' => Pages\CreateStockAdjustment::route('/create'),
            'edit' => Pages\EditStockAdjustment::route('/{record}/edit'),
        ];
    }
}
