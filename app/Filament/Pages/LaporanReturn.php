<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanReturn extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-uturn-left';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Return';
    protected static ?int $navigationSort = 110;
    protected static ?string $title = 'Laporan Return';
    protected string $view = 'filament.pages.laporan.return';

    public $startDate;
    public $endDate;
    public $totalReturns = 0;
    public $totalAmount = 0;
    public $data = [];

    public function mount(): void
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->loadData();
    }

    public function loadData(): void
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $base = DB::table('returns')->whereBetween('created_at', [$start, $end]);

        $this->totalReturns = (int) (clone $base)->count();
        $this->totalAmount = (float) (clone $base)->sum('total_amount');

        $this->data = DB::table('returns')
            ->leftJoin('outlets', 'returns.outlet_id', '=', 'outlets.id')
            ->whereBetween('returns.created_at', [$start, $end])
            ->select(
                'returns.return_number',
                'returns.type',
                'returns.status',
                'returns.total_amount',
                'returns.reason',
                'returns.created_at',
                'outlets.name as outlet_name'
            )
            ->orderByDesc('returns.created_at')
            ->limit(200)
            ->get()
            ->toArray();
    }
}
