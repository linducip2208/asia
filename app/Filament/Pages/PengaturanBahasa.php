<?php

namespace App\Filament\Pages;

use App\Models\SystemSetting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class PengaturanBahasa extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-language';
    protected static string|UnitEnum|null $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationLabel = 'Bahasa';
    protected static ?int $navigationSort = 40;
    protected string $view = 'filament.pages.pengaturan.bahasa';

    public $locale = 'id_ID';

    public array $locales = [
        'id_ID' => 'Bahasa Indonesia',
        'en_US' => 'English (US)',
    ];

    public function mount(): void
    {
        $this->locale = SystemSetting::getValue('app_locale', 'id_ID');
    }

    public function save(): void
    {
        SystemSetting::setValue('app_locale', $this->locale);

        Notification::make()
            ->title('Pengaturan bahasa berhasil disimpan!')
            ->success()
            ->send();
    }
}
