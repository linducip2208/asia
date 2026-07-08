<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanShift extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Shift Kasir';
    protected static ?int $navigationSort = 120;
    protected static ?string $title = 'Laporan Shift Kasir';
    protected string $view = 'filament.pages.laporan.shift';

    public $startDate;
    public $endDate;
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

        $this->data = DB::table('shifts')
            ->leftJoin('users', 'shifts.user_id', '=', 'users.id')
            ->leftJoin('outlets', 'shifts.outlet_id', '=', 'outlets.id')
            ->whereBetween('shifts.started_at', [$start, $end])
            ->select(
                'users.name as cashier_name',
                'outlets.name as outlet_name',
                'shifts.started_at',
                'shifts.ended_at',
                'shifts.starting_cash',
                'shifts.ending_cash',
                'shifts.expected_cash',
                'shifts.difference',
                'shifts.status'
            )
            ->orderByDesc('shifts.started_at')
            ->limit(200)
            ->get()
            ->toArray();
    }
}
