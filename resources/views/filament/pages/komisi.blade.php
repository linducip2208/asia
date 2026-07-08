<x-filament-panels::page>
    <div class="flex flex-wrap gap-4 mb-6 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
            <input type="month" wire:model.live="period" class="rounded-lg border-gray-300 text-sm">
        </div>
    </div>

    @php
        $totalSales = collect($data)->sum('total_sales');
        $totalCommission = collect($data)->sum('total_commission');
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Penjualan</div>
            <div class="text-2xl font-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Komisi</div>
            <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalCommission, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Jumlah Pegawai</div>
            <div class="text-2xl font-bold">{{ count($data) }}</div>
        </x-filament::section>
    </div>

    <x-filament::section>
        <h3 class="text-lg font-semibold mb-4">Komisi Pegawai — {{ $period }}</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-2 font-semibold text-gray-500">#</th>
                        <th class="py-2 font-semibold text-gray-500">Pegawai</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Total Penjualan</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Order</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Komisi</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Bonus</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Total Komisi</th>
                        <th class="py-2 font-semibold text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $row)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-400">{{ $i + 1 }}</td>
                        <td class="py-2 font-medium">{{ $row['name'] }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row['total_sales'], 0, ',', '.') }}</td>
                        <td class="py-2 text-right">{{ $row['total_orders'] }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row['commission'], 0, ',', '.') }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row['bonus'], 0, ',', '.') }}</td>
                        <td class="py-2 text-right font-semibold text-emerald-600">Rp {{ number_format($row['total_commission'], 0, ',', '.') }}</td>
                        <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">{{ $row['status'] }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="py-8 text-center text-gray-400">Belum ada data komisi untuk periode ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
