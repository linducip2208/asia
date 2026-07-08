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
        <h3 class="text-lg font-semibold mb-4">Laporan Customer</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-2 font-semibold text-gray-500">#</th>
                        <th class="py-2 font-semibold text-gray-500">Nama</th>
                        <th class="py-2 font-semibold text-gray-500">Telepon</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Total Belanja</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Jumlah Order</th>
                        <th class="py-2 font-semibold text-gray-500">Order Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $row)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-400">{{ $i + 1 }}</td>
                        <td class="py-2 font-medium">{{ $row->name }}</td>
                        <td class="py-2 text-gray-500">{{ $row->phone ?: '-' }}</td>
                        <td class="py-2 text-right font-semibold">Rp {{ number_format($row->total_spent, 0, ',', '.') }}</td>
                        <td class="py-2 text-right">{{ $row->total_orders }}</td>
                        <td class="py-2 text-gray-500">{{ $row->last_order ? \Carbon\Carbon::parse($row->last_order)->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
