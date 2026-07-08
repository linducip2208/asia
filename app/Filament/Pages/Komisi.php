<?php

namespace App\Filament\Pages;

use App\Models\Commission;
use App\Models\Order;
use App\Models\User;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Komisi extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string|\UnitEnum|null $navigationGroup = '👨‍💼 Pegawai';
    protected static ?string $navigationLabel = 'Komisi';
    protected static ?int $navigationSort = 40;
    protected static ?string $title = 'Komisi Pegawai';
    protected string $view = 'filament.pages.komisi';

    public string $period;
    public array $data = [];

    public function mount(): void
    {
        $this->period = Carbon::now()->format('Y-m');
        $this->loadData();
    }

    public function updatedPeriod(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        $start = Carbon::parse($this->period.'-01')->startOfMonth();
        $end = (clone $start)->endOfMonth();

        $stored = Commission::where('period', $this->period)->get()->keyBy('user_id');

        $sales = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed')
            ->select('user_id', DB::raw('SUM(total_amount) as total_sales'), DB::raw('COUNT(*) as total_orders'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $userIds = $sales->keys()->merge($stored->keys())->unique()->filter();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        $rows = [];
        foreach ($userIds as $uid) {
            $user = $users->get($uid);
            if (! $user) {
                continue;
            }
            $saleRow = $sales->get($uid);
            $commRow = $stored->get($uid);
            $rows[] = [
                'name' => $user->name,
                'total_sales' => (float) ($saleRow->total_sales ?? ($commRow->total_sales ?? 0)),
                'total_orders' => (int) ($saleRow->total_orders ?? 0),
                'commission' => (float) ($commRow->commission_amount ?? 0),
                'bonus' => (float) ($commRow->bonus_amount ?? 0),
                'total_commission' => (float) ($commRow->total_commission ?? 0),
                'status' => $commRow->status ?? 'belum dihitung',
            ];
        }

        usort($rows, fn ($a, $b) => $b['total_sales'] <=> $a['total_sales']);

        $this->data = $rows;
    }
}
