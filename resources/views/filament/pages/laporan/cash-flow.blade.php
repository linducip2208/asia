<x-filament-panels::page>
    <div class="flex gap-4 mb-6">
        <input type="date" wire:model="startDate" class="rounded-lg border" wire:change="loadData">
        <input type="date" wire:model="endDate" class="rounded-lg border" wire:change="loadData">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <x-filament::section><div class="text-sm text-gray-500">Saldo Awal</div><div class="text-lg font-bold">Rp {{ number_format($openingBalance, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Kas Masuk</div><div class="text-lg font-bold text-green-600">Rp {{ number_format($cashIn, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Kas Keluar</div><div class="text-lg font-bold text-red-600">Rp {{ number_format($cashOut, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Net Cash Flow</div><div class="text-lg font-bold {{ $netCashFlow >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($netCashFlow, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Saldo Akhir</div><div class="text-lg font-bold">Rp {{ number_format($closingBalance, 0, ',', '.') }}</div></x-filament::section>
    </div>
</x-filament-panels::page>
