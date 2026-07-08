<x-filament-panels::page>
    <div class="space-y-6">
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center rounded-lg bg-danger-100 p-3 text-danger-600 dark:bg-danger-500/10">
                    <x-heroicon-o-exclamation-circle class="h-6 w-6" />
                </span>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Produk Habis Stok</p>
                    <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->totalCount }}</p>
                </div>
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">SKU</th>
                        <th class="px-4 py-3 text-right">Stok</th>
                        <th class="px-4 py-3 text-right">Min Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($this->products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-3 font-medium text-gray-950 dark:text-white">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $product->sku ?? '-' }}</td>
                            <td class="px-4 py-3 text-right"><span class="inline-flex rounded-md bg-danger-100 px-2 py-0.5 text-xs font-semibold text-danger-700 dark:bg-danger-500/10 dark:text-danger-400">{{ $product->current_stock }}</span></td>
                            <td class="px-4 py-3 text-right text-gray-500 dark:text-gray-400">{{ $product->min_stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Tidak ada produk yang habis stok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $this->products->links() }}</div>
    </div>
</x-filament-panels::page>
