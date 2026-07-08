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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Return</div>
            <div class="text-2xl font-bold">{{ $totalReturns }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Nilai Return</div>
            <div class="text-2xl font-bold text-rose-600">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
        </x-filament::section>
    </div>

    <x-filament::section>
        <h3 class="text-lg font-semibold mb-4">Daftar Return</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-2 font-semibold text-gray-500">No. Return</th>
                        <th class="py-2 font-semibold text-gray-500">Tipe</th>
                        <th class="py-2 font-semibold text-gray-500">Outlet</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Nilai</th>
                        <th class="py-2 font-semibold text-gray-500">Alasan</th>
                        <th class="py-2 font-semibold text-gray-500">Status</th>
                        <th class="py-2 font-semibold text-gray-500">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 font-mono text-xs">{{ $row->return_number }}</td>
                        <td class="py-2">{{ $row->type === 'customer_return' ? 'Customer' : 'Supplier' }}</td>
                        <td class="py-2 text-gray-500">{{ $row->outlet_name ?: '-' }}</td>
                        <td class="py-2 text-right font-semibold">Rp {{ number_format($row->total_amount, 0, ',', '.') }}</td>
                        <td class="py-2 text-gray-500">{{ $row->reason ?: '-' }}</td>
                        <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">{{ $row->status }}</span></td>
                        <td class="py-2 text-gray-500">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-8 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
