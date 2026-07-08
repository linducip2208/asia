<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesTargetResource\Pages;
use App\Models\SalesTarget;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SalesTargetResource extends Resource
{
    protected static ?string $model = SalesTarget::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-flag';
    protected static string|\UnitEnum|null $navigationGroup = '👨‍💼 Pegawai';
    protected static ?string $navigationLabel = 'Target Penjualan';
    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Target Penjualan')->schema([
                Forms\Components\Select::make('user_id')->label('Pegawai')->relationship('user', 'name')->searchable()->preload()->required(),
                Forms\Components\Select::make('outlet_id')->label('Outlet')->relationship('outlet', 'name')->searchable()->preload()->nullable(),
                Forms\Components\TextInput::make('period')->label('Periode (YYYY-MM)')->placeholder('2026-07')->default(fn () => now()->format('Y-m'))->required()->maxLength(7),
                Forms\Components\TextInput::make('target_amount')->label('Target')->numeric()->prefix('Rp')->required(),
                Forms\Components\TextInput::make('achieved_amount')->label('Tercapai')->numeric()->prefix('Rp')->disabled()->dehydrated(false),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')->label('Pegawai')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('outlet.name')->label('Outlet')->searchable(),
            Tables\Columns\TextColumn::make('period')->label('Periode')->sortable(),
            Tables\Columns\TextColumn::make('target_amount')->label('Target')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('achieved_amount')->label('Tercapai')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('achievement_percent')->label('Pencapaian')->suffix('%')->badge()->color(fn ($state) => $state >= 100 ? 'success' : ($state >= 75 ? 'warning' : 'danger'))->sortable(),
        ])->defaultSort('period', 'desc')->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalesTargets::route('/'),
            'create' => Pages\CreateSalesTarget::route('/create'),
            'edit' => Pages\EditSalesTarget::route('/{record}/edit'),
        ];
    }
}
