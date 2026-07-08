<?php

namespace App\Filament\Pages;

use App\Models\Provider;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class IntegrasiEmail extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-envelope';
    protected static string|UnitEnum|null $navigationGroup = '🔗 Integrasi';
    protected static ?string $navigationLabel = 'Email SMTP';
    protected static ?int $navigationSort = 20;
    protected string $view = 'filament.pages.integrasi.email';

    public $smtp_host = '';
    public $smtp_port = '587';
    public $smtp_username = '';
    public $smtp_password = '';
    public $smtp_encryption = 'tls';
    public $from_address = '';
    public $from_name = '';

    public function mount(): void
    {
        $provider = Provider::where('type', 'email')->first();

        if ($provider) {
            $this->smtp_host = $provider->base_url ?? '';
            $this->smtp_port = $provider->extra_config['smtp_port'] ?? '587';
            $this->smtp_username = $provider->merchant_id ?? '';
            $this->smtp_password = $provider->decryptApiSecret() ?? '';
            $this->smtp_encryption = $provider->extra_config['smtp_encryption'] ?? 'tls';
            $this->from_address = $provider->extra_config['from_address'] ?? '';
            $this->from_name = $provider->extra_config['from_name'] ?? '';
        }
    }

    public function save(): void
    {
        Provider::updateOrCreate(
            ['type' => 'email'],
            [
                'name' => 'SMTP Email',
                'api_format' => 'smtp',
                'base_url' => $this->smtp_host,
                'merchant_id' => $this->smtp_username,
                'api_secret_encrypted' => $this->smtp_password ? encrypt($this->smtp_password) : null,
                'extra_config' => [
                    'smtp_port' => $this->smtp_port,
                    'smtp_encryption' => $this->smtp_encryption,
                    'from_address' => $this->from_address,
                    'from_name' => $this->from_name,
                ],
                'is_active' => true,
            ]
        );

        Notification::make()
            ->title('Email SMTP berhasil disimpan!')
            ->success()
            ->send();
    }
}
