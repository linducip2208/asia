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
            <div class="text-sm text-gray-500">Total DPP (Dasar Pengenaan Pajak)</div>
            <div class="text-2xl font-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
        </x-filament::section>
        <x-filament::section>
            <div class="text-sm text-gray-500">Total Pajak Keluaran</div>
            <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalTaxOutput, 0, ',', '.') }}</div>
        </x-filament::section>
    </div>

    <x-filament::section>
        <h3 class="text-lg font-semibold mb-4">Rekap Pajak Harian</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200">
                        <th class="py-2 font-semibold text-gray-500">Tanggal</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">DPP</th>
                        <th class="py-2 font-semibold text-gray-500 text-right">Pajak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr class="border-b border-gray-100">
                        <td class="py-2">{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($row->dpp, 0, ',', '.') }}</td>
                        <td class="py-2 text-right font-semibold">Rp {{ number_format($row->tax, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="py-8 text-center text-gray-400">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
