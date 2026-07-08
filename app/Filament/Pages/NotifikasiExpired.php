<?php

namespace App\Filament\Pages;

use App\Models\BatchNumber;
use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;

class NotifikasiExpired extends Page
{
    protected static string|UnitEnum|null $navigationGroup = '🔔 Notifikasi';
    protected static ?int $navigationSort = 30;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static ?string $title = 'Expired Product';
    protected static ?string $navigationLabel = 'Expired Product';
    protected string $view = 'filament.pages.notifikasi.expired';

    public function getBatchesProperty()
    {
        return BatchNumber::query()
            ->with(['product:id,name', 'warehouse:id,name'])
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('current_quantity', '>', 0)
            ->orderBy('expiry_date')
            ->paginate(25);
    }

    public function getExpiredCountProperty(): int
    {
        return BatchNumber::query()
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->where('current_quantity', '>', 0)
            ->count();
    }

    public function getExpiringSoonCountProperty(): int
    {
        return BatchNumber::query()
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now(), now()->addDays(30)])
            ->where('current_quantity', '>', 0)
            ->count();
    }
}
