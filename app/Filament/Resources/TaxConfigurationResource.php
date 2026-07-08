<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxConfigurationResource\Pages;
use App\Models\TaxConfiguration;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TaxConfigurationResource extends Resource
{
    protected static ?string $model = TaxConfiguration::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calculator';
    protected static string|\UnitEnum|null $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Pajak';
    protected static ?int $navigationSort = 70;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Konfigurasi Pajak')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Pajak')->required()->maxLength(255),
                Forms\Components\TextInput::make('code')->label('Kode')->maxLength(20),
                Forms\Components\TextInput::make('rate')->label('Tarif (%)')->numeric()->suffix('%')->required(),
                Forms\Components\Select::make('type')->label('Tipe')->options(['output' => 'Pajak Keluaran (Output)', 'input' => 'Pajak Masukan (Input)'])->default('output')->required(),
                Forms\Components\Select::make('input_coa_id')->label('Akun Pajak Masukan')->relationship('inputCoa', 'name')->searchable()->preload()->nullable(),
                Forms\Components\Select::make('output_coa_id')->label('Akun Pajak Keluaran')->relationship('outputCoa', 'name')->searchable()->preload()->nullable(),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('code')->label('Kode')->searchable(),
            Tables\Columns\TextColumn::make('rate')->label('Tarif')->suffix('%')->sortable(),
            Tables\Columns\TextColumn::make('type')->label('Tipe')->badge()->colors(['success' => 'output', 'info' => 'input'])->formatStateUsing(fn ($state) => $state === 'output' ? 'Keluaran' : 'Masukan'),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxConfigurations::route('/'),
            'create' => Pages\CreateTaxConfiguration::route('/create'),
            'edit' => Pages\EditTaxConfiguration::route('/{record}/edit'),
        ];
    }
}
