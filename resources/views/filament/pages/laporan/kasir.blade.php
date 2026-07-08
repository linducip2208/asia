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

    <x-filament::section>
        <h3 class="text-lg font-semibold mb-4">Laporan Kasir</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-2 font-semibold text-gray-500">#</th>
                        <th class="py-2 font-semibold text-gray-500">Kasir</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Total Transaksi</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Total Penjualan</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $row)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-400">{{ $i + 1 }}</td>
                        <td class="py-2 font-medium">{{ $row->name }}</td>
                        <td class="py-2 text-right">{{ $row->total_transactions }}</td>
                        <td class="py-2 text-right font-semibold">Rp {{ number_format($row->total_sales, 0, ',', '.') }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row->avg_transaction, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
