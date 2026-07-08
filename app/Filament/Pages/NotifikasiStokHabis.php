<?php

namespace App\Filament\Pages;

use App\Models\Product;
use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;

class NotifikasiStokHabis extends Page
{
    protected static string|UnitEnum|null $navigationGroup = '🔔 Notifikasi';
    protected static ?int $navigationSort = 20;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-circle';
    protected static ?string $title = 'Out Of Stock';
    protected static ?string $navigationLabel = 'Out Of Stock';
    protected string $view = 'filament.pages.notifikasi.stok-habis';

    public function getProductsProperty()
    {
        return Product::query()
            ->where('current_stock', '<=', 0)
            ->orderBy('name')
            ->paginate(25);
    }

    public function getTotalCountProperty(): int
    {
        return Product::query()->where('current_stock', '<=', 0)->count();
    }
}
