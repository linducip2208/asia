<?php

namespace App\Filament\Pages;

use App\Models\Provider;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class IntegrasiWhatsApp extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static string|UnitEnum|null $navigationGroup = '🔗 Integrasi';
    protected static ?string $navigationLabel = 'WhatsApp Gateway';
    protected static ?int $navigationSort = 10;
    protected string $view = 'filament.pages.integrasi.whatsapp';

    public $provider_name = '';
    public $api_url = '';
    public $api_key = '';
    public $sender_number = '';
    public $is_active = true;

    public function mount(): void
    {
        $provider = Provider::where('type', 'whatsapp')->first();

        if ($provider) {
            $this->provider_name = $provider->name;
            $this->api_url = $provider->base_url ?? '';
            $this->api_key = $provider->decryptApiKey() ?? '';
            $this->sender_number = $provider->extra_config['sender_number'] ?? '';
            $this->is_active = $provider->is_active;
        }
    }

    public function save(): void
    {
        Provider::updateOrCreate(
            ['type' => 'whatsapp'],
            [
                'name' => $this->provider_name ?: 'WhatsApp Gateway',
                'api_format' => 'rest-api',
                'base_url' => $this->api_url,
                'api_key_encrypted' => $this->api_key ? encrypt($this->api_key) : null,
                'extra_config' => ['sender_number' => $this->sender_number],
                'is_active' => $this->is_active,
            ]
        );

        Notification::make()
            ->title('WhatsApp Gateway berhasil disimpan!')
            ->success()
            ->send();
    }
}
