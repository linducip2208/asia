<x-filament-panels::page>
    <div class="flex gap-4 mb-6">
        <input type="date" wire:model="startDate" class="rounded-lg border" wire:change="loadData">
        <input type="date" wire:model="endDate" class="rounded-lg border" wire:change="loadData">
    </div>
    <x-filament::section>
        <table class="w-full text-sm">
            <thead><tr class="border-b"><th class="text-left py-2">#</th><th class="text-left">Produk</th><th class="text-left">Kategori</th><th class="text-right">Qty Terjual</th><th class="text-right">Revenue</th></tr></thead>
            <tbody>@foreach($products as $i => $p)<tr class="border-b"><td class="py-2">{{ $i + 1 }}</td><td>{{ $p['name'] }} <span class="text-gray-400">({{ $p['sku'] }})</span></td><td>{{ $p['category_name'] }}</td><td class="text-right font-bold">{{ $p['total_qty'] }}</td><td class="text-right font-bold">Rp {{ number_format($p['total_revenue'], 0, ',', '.') }}</td></tr>@endforeach</tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
