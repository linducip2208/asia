<x-filament-panels::page>
    <div class="flex flex-wrap gap-4 mb-6 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dari</label>
            <input type="date" wire:model="startDate" wire:change="loadData" class="rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai</label>
            <input type="date" wire:model="endDate" wire:change="loadData" class="rounded-lg border-gray-300 text-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Penjualan</div>
            <div class="text-xl font-bold text-emerald-600">Rp {{ number_format($totals['sales'] ?? 0, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Pembelian</div>
            <div class="text-xl font-bold text-amber-600">Rp {{ number_format($totals['purchases'] ?? 0, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Pengeluaran</div>
            <div class="text-xl font-bold text-rose-600">Rp {{ number_format($totals['expenses'] ?? 0, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Laba Kotor</div>
            <div class="text-xl font-bold {{ ($totals['profit'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">Rp {{ number_format($totals['profit'] ?? 0, 0, ',', '.') }}</div>
        </x-filament::section>
    </div>

    <x-filament::section>
        <h3 class="text-lg font-semibold mb-4">Rekap Harian</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-2 font-semibold text-gray-500">Tanggal</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Penjualan</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Pembelian</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Pengeluaran</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Laba</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr class="border-b border-gray-100">
                        <td class="py-2">{{ \Carbon\Carbon::parse($row['date'])->format('d/m/Y') }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row['sales'], 0, ',', '.') }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row['purchases'], 0, ',', '.') }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row['expenses'], 0, ',', '.') }}</td>
                        <td class="py-2 text-right font-semibold {{ $row['profit'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">Rp {{ number_format($row['profit'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
