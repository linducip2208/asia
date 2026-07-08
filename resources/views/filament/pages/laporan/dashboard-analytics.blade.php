<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <x-filament::section>
            <div class="text-sm text-gray-500">Pendapatan Hari Ini</div>
            <div class="text-2xl font-bold text-green-600">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Transaksi Hari Ini</div>
            <div class="text-2xl font-bold">{{ $todayOrders }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Produk</div>
            <div class="text-2xl font-bold">{{ $totalProducts }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Customer</div>
            <div class="text-2xl font-bold">{{ $totalCustomers }}</div>
        </x-filament::section>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <x-filament::section>
            <div class="text-sm text-gray-500">Bulan Ini</div>
            <div class="text-lg font-bold text-green-600">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Bulan Lalu</div>
            <div class="text-lg font-bold">Rp {{ number_format($lastMonthRevenue, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Pertumbuhan</div>
            <div class="text-lg font-bold {{ $growthPercent >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $growthPercent }}%</div>
        </x-filament::section>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-filament::section>
            <h3 class="text-lg font-semibold mb-4">Top 10 Produk Bulan Ini</h3>
            <table class="w-full text-sm"><thead><tr><th class="text-left py-1">Produk</th><th class="text-right">Qty</th></tr></thead>
            <tbody>@foreach($topProducts as $p)<tr><td class="py-1">{{ $p['name'] }}</td><td class="text-right font-bold">{{ $p['total_qty'] }}</td></tr>@endforeach</tbody></table>
        </x-filament::section>
        <x-filament::section>
            <h3 class="text-lg font-semibold mb-4">Pendapatan per Outlet</h3>
            <table class="w-full text-sm"><thead><tr><th class="text-left py-1">Outlet</th><th class="text-right">Revenue</th></tr></thead>
            <tbody>@foreach($revenueByOutlet as $o)<tr><td class="py-1">{{ $o['name'] }}</td><td class="text-right font-bold">Rp {{ number_format($o['revenue'] ?? 0, 0, ',', '.') }}</td></tr>@endforeach</tbody></table>
        </x-filament::section>
    </div>
</x-filament-panels::page>
