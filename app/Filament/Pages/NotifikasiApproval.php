<?php

namespace App\Filament\Pages;

use App\Models\ExpenseEntry;
use App\Models\PurchaseOrder;
use Filament\Pages\Page;
use BackedEnum;
use UnitEnum;

class NotifikasiApproval extends Page
{
    protected static string|UnitEnum|null $navigationGroup = '🔔 Notifikasi';
    protected static ?int $navigationSort = 40;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $title = 'Approval';
    protected static ?string $navigationLabel = 'Approval';
    protected string $view = 'filament.pages.notifikasi.approval';

    public function getPurchaseOrdersProperty()
    {
        return PurchaseOrder::query()
            ->with(['supplier:id,name', 'outlet:id,name'])
            ->whereIn('status', ['pending', 'pending_approval', 'draft'])
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();
    }

    public function getExpensesProperty()
    {
        return ExpenseEntry::query()
            ->with(['outlet:id,name', 'cashAccount:id,name'])
            ->whereIn('status', ['pending', 'pending_approval', 'draft'])
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();
    }

    public function getPoCountProperty(): int
    {
        return PurchaseOrder::query()->whereIn('status', ['pending', 'pending_approval', 'draft'])->count();
    }

    public function getExpenseCountProperty(): int
    {
        return ExpenseEntry::query()->whereIn('status', ['pending', 'pending_approval', 'draft'])->count();
    }
}
