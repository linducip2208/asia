<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberPromoResource\Pages;
use App\Models\MemberPromo;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MemberPromoResource extends Resource
{
    protected static ?string $model = MemberPromo::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected static string|\UnitEnum|null $navigationGroup = '🎁 Promo';
    protected static ?string $navigationLabel = 'Promo Member';
    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Promo Member')->schema([
                Forms\Components\TextInput::make('name')->label('Nama Promo')->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\Select::make('membership_tier_id')->label('Tier Membership')->relationship('membershipTier', 'name')->searchable()->preload()->nullable(),
                Forms\Components\Select::make('discount_type')->label('Tipe Diskon')->options(['percent' => 'Persentase', 'fixed' => 'Nominal Tetap'])->default('percent')->required(),
                Forms\Components\TextInput::make('discount_value')->label('Nilai Diskon')->numeric()->required(),
                Forms\Components\TextInput::make('min_purchase')->label('Min Pembelian (Rp)')->numeric()->prefix('Rp')->default(0),
                Forms\Components\TextInput::make('max_discount')->label('Maks Diskon (Rp)')->numeric()->prefix('Rp')->nullable(),
                Forms\Components\TextInput::make('max_usage_per_day')->label('Maks Penggunaan/Hari')->numeric()->nullable(),
            ])->columns(2),
            Section::make('Masa Berlaku')->schema([
                Forms\Components\TextInput::make('applicable_days')->label('Hari Berlaku')->placeholder('kosong = setiap hari, atau: monday,friday')->nullable(),
                Forms\Components\DatePicker::make('valid_from')->label('Berlaku Dari'),
                Forms\Components\DatePicker::make('valid_until')->label('Berlaku Sampai'),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\Toggle::make('is_stackable')->label('Dapat Digabung'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama Promo')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('membershipTier.name')->label('Tier')->badge()->searchable(),
            Tables\Columns\TextColumn::make('discount_type')->label('Tipe')->badge(),
            Tables\Columns\TextColumn::make('discount_value')->label('Nilai')->numeric()->sortable(),
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
            'index' => Pages\ListMemberPromos::route('/'),
            'create' => Pages\CreateMemberPromo::route('/create'),
            'edit' => Pages\EditMemberPromo::route('/{record}/edit'),
        ];
    }
}
