<x-filament-panels::page>
    <div class="flex gap-4 mb-6">
        <input type="date" wire:model="startDate" class="rounded-lg border" wire:change="loadData">
        <input type="date" wire:model="endDate" class="rounded-lg border" wire:change="loadData">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <x-filament::section><div class="text-sm text-gray-500">Pendapatan</div><div class="text-lg font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">HPP</div><div class="text-lg font-bold text-red-600">Rp {{ number_format($totalCOGS, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Laba Kotor</div><div class="text-lg font-bold {{ $grossProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($grossProfit, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Beban</div><div class="text-lg font-bold text-red-600">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Laba Bersih</div><div class="text-lg font-bold {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($netProfit, 0, ',', '.') }}</div></x-filament::section>
    </div>
</x-filament-panels::page>
