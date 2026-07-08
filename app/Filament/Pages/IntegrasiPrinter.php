<?php

namespace App\Filament\Pages;

use App\Models\Provider;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class IntegrasiPrinter extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-printer';
    protected static string|UnitEnum|null $navigationGroup = '🔗 Integrasi';
    protected static ?string $navigationLabel = 'Printer';
    protected static ?int $navigationSort = 40;
    protected string $view = 'filament.pages.integrasi.printer';

    public $printers = [];
    public $editingName = '';
    public $editingType = 'bluetooth';
    public $editingAddress = '';
    public $editingPaperSize = '80mm';
    public $editingCharsPerLine = '48';
    public $editingIsActive = true;
    public $editingIsDefault = false;
    public $editId = null;

    public function mount(): void
    {
        $this->loadPrinters();
    }

    public function loadPrinters(): void
    {
        $this->printers = Provider::where('type', 'printer')->get()->toArray();
    }

    public function edit($id): void
    {
        $printer = Provider::findOrFail($id);
        $this->editId = $printer->id;
        $this->editingName = $printer->name;
        $this->editingType = $printer->api_format;
        $this->editingAddress = $printer->base_url ?? '';
        $this->editingPaperSize = $printer->extra_config['paper_size'] ?? '80mm';
        $this->editingCharsPerLine = $printer->extra_config['characters_per_line'] ?? '48';
        $this->editingIsActive = $printer->is_active;
        $this->editingIsDefault = $printer->is_default;
    }

    public function save(): void
    {
        if ($this->editingIsDefault) {
            Provider::where('type', 'printer')->update(['is_default' => false]);
        }

        $data = [
            'name' => $this->editingName,
            'type' => 'printer',
            'api_format' => $this->editingType,
            'base_url' => $this->editingAddress,
            'extra_config' => [
                'paper_size' => $this->editingPaperSize,
                'characters_per_line' => $this->editingCharsPerLine,
            ],
            'is_active' => $this->editingIsActive,
            'is_default' => $this->editingIsDefault,
        ];

        if ($this->editId) {
            Provider::where('id', $this->editId)->update($data);
        } else {
            Provider::create($data);
        }

        $this->resetForm();
        $this->loadPrinters();

        Notification::make()
            ->title('Printer berhasil disimpan!')
            ->success()
            ->send();
    }

    public function delete($id): void
    {
        Provider::where('id', $id)->delete();
        $this->loadPrinters();

        Notification::make()
            ->title('Printer berhasil dihapus!')
            ->success()
            ->send();
    }

    public function setDefault($id): void
    {
        Provider::where('type', 'printer')->update(['is_default' => false]);
        Provider::where('id', $id)->update(['is_default' => true]);
        $this->loadPrinters();

        Notification::make()
            ->title('Printer default diubah!')
            ->success()
            ->send();
    }

    public function resetForm(): void
    {
        $this->editId = null;
        $this->editingName = '';
        $this->editingType = 'bluetooth';
        $this->editingAddress = '';
        $this->editingPaperSize = '80mm';
        $this->editingCharsPerLine = '48';
        $this->editingIsActive = true;
        $this->editingIsDefault = false;
    }
}
