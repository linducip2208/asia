<?php

namespace App\Filament\Pages;

use App\Models\SystemSetting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class PengaturanZonaWaktu extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';
    protected static string|UnitEnum|null $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationLabel = 'Zona Waktu';
    protected static ?int $navigationSort = 50;
    protected string $view = 'filament.pages.pengaturan.zona-waktu';

    public $timezone = 'Asia/Jakarta';

    public array $timezones = [
        'Asia/Jakarta' => 'WIB - Asia/Jakarta (UTC+7)',
        'Asia/Makassar' => 'WITA - Asia/Makassar (UTC+8)',
        'Asia/Jayapura' => 'WIT - Asia/Jayapura (UTC+9)',
        'Asia/Pontianak' => 'WIB - Asia/Pontianak (UTC+7)',
        'Asia/Singapore' => 'Asia/Singapore (UTC+8)',
        'Asia/Kuala_Lumpur' => 'Asia/Kuala Lumpur (UTC+8)',
        'UTC' => 'UTC (UTC+0)',
    ];

    public function mount(): void
    {
        $this->timezone = SystemSetting::getValue('app_timezone', 'Asia/Jakarta');
    }

    public function save(): void
    {
        SystemSetting::setValue('app_timezone', $this->timezone);

        Notification::make()
            ->title('Pengaturan zona waktu berhasil disimpan!')
            ->success()
            ->send();
    }
}
