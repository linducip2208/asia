<?php

namespace App\Filament\Pages;

use App\Models\Provider;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class IntegrasiPayment extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';
    protected static string|UnitEnum|null $navigationGroup = '🔗 Integrasi';
    protected static ?string $navigationLabel = 'Payment Gateway';
    protected static ?int $navigationSort = 30;
    protected string $view = 'filament.pages.integrasi.payment';

    public $selected_provider = 'midtrans';

    public $midtrans_server_key = '';
    public $midtrans_client_key = '';
    public $midtrans_merchant_id = '';
    public $midtrans_is_production = false;
    public $midtrans_is_active = true;

    public $xendit_api_key = '';
    public $xendit_callback_token = '';
    public $xendit_is_active = true;

    public $qris_merchant_name = '';
    public $qris_terminal_id = '';
    public $qris_type = 'static';

    public function mount(): void
    {
        $this->loadMidtransConfig();
        $this->loadXenditConfig();
        $this->loadQrisConfig();
    }

    protected function loadMidtransConfig(): void
    {
        $provider = Provider::where('type', 'payment')->where('api_format', 'midtrans')->first();
        if ($provider) {
            $this->midtrans_server_key = $provider->decryptApiSecret() ?? '';
            $this->midtrans_client_key = $provider->decryptApiKey() ?? '';
            $this->midtrans_merchant_id = $provider->merchant_id ?? '';
            $this->midtrans_is_production = (bool) ($provider->extra_config['is_production'] ?? false);
            $this->midtrans_is_active = $provider->is_active;
        }
    }

    protected function loadXenditConfig(): void
    {
        $provider = Provider::where('type', 'payment')->where('api_format', 'xendit')->first();
        if ($provider) {
            $this->xendit_api_key = $provider->decryptApiKey() ?? '';
            $this->xendit_callback_token = $provider->extra_config['callback_token'] ?? '';
            $this->xendit_is_active = $provider->is_active;
        }
    }

    protected function loadQrisConfig(): void
    {
        $provider = Provider::where('type', 'payment')->where('api_format', 'qris')->first();
        if ($provider) {
            $this->qris_merchant_name = $provider->name ?? '';
            $this->qris_terminal_id = $provider->merchant_id ?? '';
            $this->qris_type = $provider->extra_config['qris_type'] ?? 'static';
        }
    }

    public function save(): void
    {
        if ($this->selected_provider === 'midtrans') {
            Provider::updateOrCreate(
                ['type' => 'payment', 'api_format' => 'midtrans'],
                [
                    'name' => 'Midtrans',
                    'base_url' => $this->midtrans_is_production
                        ? 'https://app.midtrans.com/snap/v1'
                        : 'https://app.sandbox.midtrans.com/snap/v1',
                    'api_key_encrypted' => $this->midtrans_client_key ? encrypt($this->midtrans_client_key) : null,
                    'api_secret_encrypted' => $this->midtrans_server_key ? encrypt($this->midtrans_server_key) : null,
                    'merchant_id' => $this->midtrans_merchant_id,
                    'extra_config' => ['is_production' => $this->midtrans_is_production],
                    'is_active' => $this->midtrans_is_active,
                ]
            );
        } elseif ($this->selected_provider === 'xendit') {
            Provider::updateOrCreate(
                ['type' => 'payment', 'api_format' => 'xendit'],
                [
                    'name' => 'Xendit',
                    'base_url' => 'https://api.xendit.co',
                    'api_key_encrypted' => $this->xendit_api_key ? encrypt($this->xendit_api_key) : null,
                    'extra_config' => ['callback_token' => $this->xendit_callback_token],
                    'is_active' => $this->xendit_is_active,
                ]
            );
        } elseif ($this->selected_provider === 'qris') {
            Provider::updateOrCreate(
                ['type' => 'payment', 'api_format' => 'qris'],
                [
                    'name' => $this->qris_merchant_name ?: 'QRIS',
                    'merchant_id' => $this->qris_terminal_id,
                    'extra_config' => ['qris_type' => $this->qris_type],
                    'is_active' => true,
                ]
            );
        }

        Notification::make()
            ->title('Payment Gateway berhasil disimpan!')
            ->success()
            ->send();
    }
}
