<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">Tenant Aktif</p>
                <p class="mt-2 text-3xl font-bold text-success-600 dark:text-success-400">{{ $totalActive }}</p>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">Trial</p>
                <p class="mt-2 text-3xl font-bold text-warning-600 dark:text-warning-400">{{ $totalTrial }}</p>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">MRR (Bulan Ini)</p>
                <p class="mt-2 text-3xl font-bold text-primary-600 dark:text-primary-400">Rp {{ number_format($mrr, 0, ',', '.') }}</p>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">Churn Rate</p>
                <p class="mt-2 text-3xl font-bold text-danger-600 dark:text-danger-400">{{ $churnRate }}%</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">Tenant Suspended</p>
                <p class="mt-2 text-2xl font-bold text-gray-950 dark:text-white">{{ $totalSuspended }}</p>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">Tenant Expired</p>
                <p class="mt-2 text-2xl font-bold text-gray-950 dark:text-white">{{ $totalExpired }}</p>
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5"><h3 class="text-base font-semibold text-gray-950 dark:text-white">Invoice Terbaru</h3></div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-white/5 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-3 text-left">No Invoice</th>
                        <th class="px-4 py-3 text-left">Tenant</th>
                        <th class="px-4 py-3 text-left">Paket</th>
                        <th class="px-4 py-3 text-right">Jumlah</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse ($recentInvoices as $invoice)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-3 font-medium text-gray-950 dark:text-white">{{ $invoice->invoice_number }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $invoice->tenant?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $invoice->subscriptionPlan?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format((float) $invoice->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                @php $color = $invoice->status === 'paid' ? 'success' : ($invoice->status === 'overdue' ? 'danger' : 'warning'); @endphp
                                <span class="inline-flex rounded-md bg-{{ $color }}-100 px-2 py-0.5 text-xs font-semibold text-{{ $color }}-700 dark:bg-{{ $color }}-500/10 dark:text-{{ $color }}-400">{{ $invoice->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada invoice.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-panels::page>
