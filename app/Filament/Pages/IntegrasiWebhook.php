<?php

namespace App\Filament\Pages;

use App\Models\Provider;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class IntegrasiWebhook extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-link';
    protected static string|UnitEnum|null $navigationGroup = '🔗 Integrasi';
    protected static ?string $navigationLabel = 'Webhook';
    protected static ?int $navigationSort = 60;
    protected string $view = 'filament.pages.integrasi.webhook';

    public $webhooks = [];
    public $editingName = '';
    public $editingUrl = '';
    public $editingEvent = 'order.created';
    public $editingSecretKey = '';
    public $editingIsActive = true;
    public $editId = null;

    public $availableEvents = [
        'order.created' => 'Order Dibuat',
        'order.completed' => 'Order Selesai',
        'payment.received' => 'Pembayaran Diterima',
        'payment.failed' => 'Pembayaran Gagal',
        'product.created' => 'Produk Baru',
        'product.updated' => 'Produk Diupdate',
        'customer.created' => 'Customer Baru',
        'stock.low' => 'Stok Menipis',
    ];

    public function mount(): void
    {
        $this->loadWebhooks();
    }

    public function loadWebhooks(): void
    {
        $this->webhooks = Provider::where('type', 'webhook')->get()->toArray();
    }

    public function edit($id): void
    {
        $webhook = Provider::findOrFail($id);
        $this->editId = $webhook->id;
        $this->editingName = $webhook->name;
        $this->editingUrl = $webhook->base_url ?? '';
        $this->editingEvent = $webhook->api_format;
        $this->editingSecretKey = $webhook->decryptApiSecret() ?? '';
        $this->editingIsActive = $webhook->is_active;
    }

    public function save(): void
    {
        $data = [
            'name' => $this->editingName,
            'type' => 'webhook',
            'api_format' => $this->editingEvent,
            'base_url' => $this->editingUrl,
            'api_secret_encrypted' => $this->editingSecretKey ? encrypt($this->editingSecretKey) : null,
            'is_active' => $this->editingIsActive,
        ];

        if ($this->editId) {
            Provider::where('id', $this->editId)->update($data);
        } else {
            Provider::create($data);
        }

        $this->resetForm();
        $this->loadWebhooks();

        Notification::make()
            ->title('Webhook berhasil disimpan!')
            ->success()
            ->send();
    }

    public function delete($id): void
    {
        Provider::where('id', $id)->delete();
        $this->loadWebhooks();

        Notification::make()
            ->title('Webhook berhasil dihapus!')
            ->success()
            ->send();
    }

    public function resetForm(): void
    {
        $this->editId = null;
        $this->editingName = '';
        $this->editingUrl = '';
        $this->editingEvent = 'order.created';
        $this->editingSecretKey = '';
        $this->editingIsActive = true;
    }
}
