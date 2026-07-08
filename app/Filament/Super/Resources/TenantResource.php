<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\TenantResource\Pages;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = '🏢 Tenant';
    protected static ?string $navigationLabel = 'Daftar Tenant';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tenant')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Tenant')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (Subdomain)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->helperText('Digunakan sebagai subdomain: slug.erpasia.test'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telepon')
                            ->maxLength(30),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3),
                        Forms\Components\TextInput::make('npwp')
                            ->label('NPWP')
                            ->maxLength(30),
                    ])->columns(2),

                Forms\Components\Section::make('Subscription')
                    ->schema([
                        Forms\Components\Select::make('subscription_plan_id')
                            ->label('Paket Subscription')
                            ->relationship('subscriptionPlan', 'name')
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'trial' => 'Trial',
                                'active' => 'Aktif',
                                'suspended' => 'Suspend',
                                'expired' => 'Expired',
                            ])
                            ->default('trial')
                            ->required(),
                        Forms\Components\DateTimePicker::make('trial_ends_at')
                            ->label('Trial Berakhir'),
                        Forms\Components\DateTimePicker::make('subscription_ends_at')
                            ->label('Subscription Berakhir'),
                    ])->columns(2),

                Forms\Components\Section::make('White Label')
                    ->schema([
                        Forms\Components\TextInput::make('custom_domain')
                            ->label('Custom Domain')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('logo_url')
                            ->label('URL Logo')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('favicon_url')
                            ->label('URL Favicon')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\ColorPicker::make('primary_color')
                            ->label('Warna Utama')
                            ->default('#3B82F6'),
                    ])->columns(2),

                Forms\Components\Section::make('Batasan')
                    ->schema([
                        Forms\Components\TextInput::make('max_outlets')
                            ->label('Max Outlet')
                            ->numeric()
                            ->default(1),
                        Forms\Components\TextInput::make('max_users')
                            ->label('Max User')
                            ->numeric()
                            ->default(5),
                        Forms\Components\TextInput::make('max_products')
                            ->label('Max Produk')
                            ->numeric()
                            ->default(1000),
                        Forms\Components\TextInput::make('max_transactions_per_day')
                            ->label('Max Transaksi/Hari')
                            ->numeric()
                            ->default(200),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tenant')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Subdomain')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subscriptionPlan.name')
                    ->label('Paket')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'trial',
                        'danger' => 'suspended',
                        'gray' => 'expired',
                    ]),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('User')
                    ->counts('users'),
                Tables\Columns\TextColumn::make('subscription_ends_at')
                    ->label('Langganan Sampai')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Daftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'trial' => 'Trial',
                        'active' => 'Aktif',
                        'suspended' => 'Suspend',
                        'expired' => 'Expired',
                    ]),
                Tables\Filters\SelectFilter::make('subscription_plan_id')
                    ->label('Paket')
                    ->relationship('subscriptionPlan', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('login_as')
                    ->label('Login Sebagai')
                    ->icon('heroicon-o-arrow-right-on-rectangle')
                    ->color('success')
                    ->url(fn (Tenant $record) => '/admin')
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
