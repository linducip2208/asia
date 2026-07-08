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
        <h3 class="text-lg font-semibold mb-4">Laporan Shift Kasir</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-2 font-semibold text-gray-500">Kasir</th>
                        <th class="py-2 font-semibold text-gray-500">Outlet</th>
                        <th class="py-2 font-semibold text-gray-500">Mulai</th>
                        <th class="py-2 font-semibold text-gray-500">Selesai</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Kas Awal</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Kas Akhir</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Selisih</th>
                        <th class="py-2 font-semibold text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 font-medium">{{ $row->cashier_name ?: '-' }}</td>
                        <td class="py-2 text-gray-500">{{ $row->outlet_name ?: '-' }}</td>
                        <td class="py-2 text-xs text-gray-500">{{ $row->started_at ? \Carbon\Carbon::parse($row->started_at)->format('d/m/y H:i') : '-' }}</td>
                        <td class="py-2 text-xs text-gray-500">{{ $row->ended_at ? \Carbon\Carbon::parse($row->ended_at)->format('d/m/y H:i') : '-' }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row->starting_cash, 0, ',', '.') }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row->ending_cash ?? 0, 0, ',', '.') }}</td>
                        <td class="py-2 text-right font-semibold {{ ($row->difference ?? 0) < 0 ? 'text-rose-600' : 'text-emerald-600' }}">Rp {{ number_format($row->difference ?? 0, 0, ',', '.') }}</td>
                        <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs {{ $row->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">{{ $row->status === 'active' ? 'Aktif' : 'Tutup' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="py-8 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
