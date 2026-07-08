<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftVoucherResource\Pages;
use App\Models\GiftVoucher;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GiftVoucherResource extends Resource
{
    protected static ?string $model = GiftVoucher::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-ticket';
    protected static string|\UnitEnum|null $navigationGroup = '🎁 Promo';
    protected static ?string $navigationLabel = 'Voucher';
    protected static ?int $navigationSort = 21;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Voucher')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Voucher')->required()->maxLength(255),
                Forms\Components\TextInput::make('code')->label('Kode')->disabled()->dehydrated(false)->placeholder('Otomatis'),
                Forms\Components\Select::make('type')->label('Tipe')->options(['fixed' => 'Nominal Tetap', 'percent' => 'Persentase'])->default('fixed')->required(),
                Forms\Components\TextInput::make('value')->label('Nilai')->numeric()->required(),
                Forms\Components\TextInput::make('min_purchase')->label('Min. Pembelian')->numeric()->prefix('Rp')->default(0),
                Forms\Components\TextInput::make('max_uses')->label('Maks. Penggunaan')->numeric()->default(1),
                Forms\Components\DatePicker::make('valid_from')->label('Berlaku Dari'),
                Forms\Components\DatePicker::make('valid_until')->label('Berlaku Sampai'),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\Textarea::make('terms_conditions')->label('Syarat & Ketentuan')->rows(3)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('code')->label('Kode')->searchable()->badge()->color('gray'),
            Tables\Columns\TextColumn::make('type')->label('Tipe')->badge()->colors(['success' => 'fixed', 'info' => 'percent'])->formatStateUsing(fn ($state) => $state === 'fixed' ? 'Nominal' : 'Persen'),
            Tables\Columns\TextColumn::make('value')->label('Nilai')->money('IDR')->sortable(),
            Tables\Columns\TextColumn::make('used_count')->label('Terpakai')->formatStateUsing(fn ($record) => "{$record->used_count} / {$record->max_uses}"),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
        ])->defaultSort('created_at', 'desc')->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGiftVouchers::route('/'),
            'create' => Pages\CreateGiftVoucher::route('/create'),
            'edit' => Pages\EditGiftVoucher::route('/{record}/edit'),
        ];
    }
}
