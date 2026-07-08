<x-filament-panels::page>
    <div class="space-y-8">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-primary-100 p-3 text-primary-600 dark:bg-primary-500/10">
                        <x-heroicon-o-shopping-cart class="h-6 w-6" />
                    </span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Purchase Order Menunggu</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->poCount }}</p>
                    </div>
                </div>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-warning-100 p-3 text-warning-600 dark:bg-warning-500/10">
                        <x-heroicon-o-banknotes class="h-6 w-6" />
                    </span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengeluaran Menunggu</p>
                        <p class="text-2xl font-bold text-gray-950 dark:text-white">{{ $this->expenseCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5"><h3 class="text-base font-semibold text-gray-950 dark:text-white">Purchase Order</h3></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">No PO</th>
                        <th class="px-4 py-3 text-left">Supplier</th>
                        <th class="px-4 py-3 text-left">Outlet</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($this->purchaseOrders as $po)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-3 font-medium text-gray-950 dark:text-white">{{ $po->po_number }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $po->supplier?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $po->outlet?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format((float) $po->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center"><span class="inline-flex rounded-md bg-warning-100 px-2 py-0.5 text-xs font-semibold text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">{{ $po->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Tidak ada PO menunggu persetujuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5"><h3 class="text-base font-semibold text-gray-950 dark:text-white">Pengeluaran</h3></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">No Pengeluaran</th>
                        <th class="px-4 py-3 text-left">Outlet</th>
                        <th class="px-4 py-3 text-left">Deskripsi</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($this->expenses as $expense)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-3 font-medium text-gray-950 dark:text-white">{{ $expense->expense_number }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $expense->outlet?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($expense->description, 40) }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format((float) $expense->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center"><span class="inline-flex rounded-md bg-warning-100 px-2 py-0.5 text-xs font-semibold text-warning-700 dark:bg-warning-500/10 dark:text-warning-400">{{ $expense->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Tidak ada pengeluaran menunggu persetujuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
