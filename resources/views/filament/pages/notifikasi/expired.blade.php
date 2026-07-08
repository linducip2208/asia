<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-danger-100 p-3 text-danger-600 dark:bg-danger-500/10">
                        <x-heroicon-o-x-circle class="h-6 w-6" />
                    </span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Kedaluwarsa</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->expiredCount }}</p>
                    </div>
                </div>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-warning-100 p-3 text-warning-600 dark:bg-warning-500/10">
                        <x-heroicon-o-clock class="h-6 w-6" />
                    </span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Akan Kedaluwarsa (30 hari)</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->expiringSoonCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">Batch</th>
                        <th class="px-4 py-3 text-left">Gudang</th>
                        <th class="px-4 py-3 text-right">Qty</th>
                        <th class="px-4 py-3 text-left">Kedaluwarsa</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($this->batches as $batch)
                        @php $isExpired = $batch->expiry_date && $batch->expiry_date->isPast(); @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-3 font-medium text-gray-950 dark:text-white">{{ $batch->product?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $batch->batch_number }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $batch->warehouse?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">{{ $batch->current_quantity }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $batch->expiry_date?->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($isExpired)
                                    <span class="inline-flex rounded-md bg-danger-100 px-2 py-0.5 text-xs font-semibold text-danger-700 dark:bg-danger-500/10 dark:text-danger-400">Expired</span>
                                @else
                                    <span class="inline-flex rounded-md bg-warning-100 px-2 py-0.5 text-xs font-semibold text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">Segera</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada produk yang mendekati kedaluwarsa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>{{ $this->batches->links() }}</div>
    </div>
</x-filament-panels::page>
