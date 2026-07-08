<?php

namespace App\Filament\Pages;

use App\Models\SystemSetting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class PengaturanInvoice extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static string|UnitEnum|null $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationLabel = 'Nomor Invoice';
    protected static ?int $navigationSort = 10;
    protected string $view = 'filament.pages.pengaturan.invoice';

    public $prefix = 'INV';
    public $date_format = 'Ymd';
    public $number_length = '4';
    public $next_number = '1';
    public $separator = '-';

    public function mount(): void
    {
        $this->prefix = SystemSetting::getValue('invoice_prefix', 'INV');
        $this->date_format = SystemSetting::getValue('invoice_date_format', 'Ymd');
        $this->number_length = SystemSetting::getValue('invoice_number_length', '4');
        $this->next_number = SystemSetting::getValue('invoice_next_number', '1');
        $this->separator = SystemSetting::getValue('invoice_separator', '-');
    }

    public function getPreviewProperty(): string
    {
        $date = date($this->date_format);
        $number = str_pad($this->next_number, (int) $this->number_length, '0', STR_PAD_LEFT);

        return "{$this->prefix}{$this->separator}{$date}{$this->separator}{$number}";
    }

    public function save(): void
    {
        SystemSetting::setValue('invoice_prefix', $this->prefix);
        SystemSetting::setValue('invoice_date_format', $this->date_format);
        SystemSetting::setValue('invoice_number_length', $this->number_length);
        SystemSetting::setValue('invoice_next_number', $this->next_number);
        SystemSetting::setValue('invoice_separator', $this->separator);

        Notification::make()
            ->title('Format nomor invoice berhasil disimpan!')
            ->success()
            ->send();
    }
}
