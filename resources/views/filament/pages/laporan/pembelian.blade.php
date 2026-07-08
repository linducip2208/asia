<x-filament-panels::page>
    <div class="flex gap-4 mb-6">
        <input type="date" wire:model="startDate" class="rounded-lg border" wire:change="loadData">
        <input type="date" wire:model="endDate" class="rounded-lg border" wire:change="loadData">
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <x-filament::section><div class="text-sm text-gray-500">Total PO</div><div class="text-2xl font-bold">{{ $totalPO }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">Total Nilai</div><div class="text-2xl font-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div></x-filament::section>
        <x-filament::section><div class="text-sm text-gray-500">PO Diterima</div><div class="text-2xl font-bold text-green-600">{{ $totalReceived }}</div></x-filament::section>
    </div>
    <x-filament::section>
        <h3 class="text-lg font-semibold mb-4">PO per Supplier</h3>
        <table class="w-full text-sm"><thead><tr><th class="text-left py-1">Supplier</th><th class="text-right">Jumlah PO</th><th class="text-right">Total Nilai</th></tr></thead>
        <tbody>@foreach($poBySupplier as $s)<tr><td class="py-1">{{ $s->name }}</td><td class="text-right">{{ $s->total_po }}</td><td class="text-right font-bold">Rp {{ number_format($s->total_amount, 0, ',', '.') }}</td></tr>@endforeach</tbody></table>
    </x-filament::section>
</x-filament-panels::page>
