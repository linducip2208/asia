<div>
    <div class="flex flex-wrap gap-3 items-end mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dari</label>
            <input type="date" wire:model.live="startDate" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai</label>
            <input type="date" wire:model.live="endDate" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Outlet</label>
            <select wire:model.live="outletId" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">Semua Outlet</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($outlet->id); ?>"><?php echo e($outlet->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Grup</label>
            <select wire:model.live="groupBy" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="daily">Harian</option>
                <option value="weekly">Mingguan</option>
                <option value="monthly">Bulanan</option>
            </select>
        </div>
        <div class="ml-auto flex gap-2">
            <a href="<?php echo e(route('export.financial', ['start_date' => $this->startDate, 'end_date' => $this->endDate, 'outlet_id' => $this->outletId, 'format' => 'csv'])); ?>"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                CSV
            </a>
            <a href="<?php echo e(route('export.financial', ['start_date' => $this->startDate, 'end_date' => $this->endDate, 'outlet_id' => $this->outletId, 'format' => 'pdf'])); ?>"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Total Pendapatan</div>
            <div class="text-2xl font-extrabold text-emerald-600">Rp <?php echo e(number_format($this->totalRevenue, 0, ',', '.')); ?></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Total Pengeluaran</div>
            <div class="text-2xl font-extrabold text-rose-600">Rp <?php echo e(number_format($this->totalExpense, 0, ',', '.')); ?></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Laba / Rugi</div>
            <div class="text-2xl font-extrabold <?php echo e($this->totalProfit >= 0 ? 'text-emerald-600' : 'text-rose-600'); ?>">Rp <?php echo e(number_format(abs($this->totalProfit), 0, ',', '.')); ?></div>
            <div class="text-xs mt-1 <?php echo e($this->totalProfit >= 0 ? 'text-emerald-500' : 'text-rose-500'); ?>"><?php echo e($this->totalProfit >= 0 ? 'Laba' : 'Rugi'); ?></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Piutang Belum Lunas</div>
            <div class="text-2xl font-extrabold text-amber-600">Rp <?php echo e(number_format($this->unpaidSales, 0, ',', '.')); ?></div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Uang Masuk</div>
            <div class="text-xl font-extrabold text-emerald-600">Rp <?php echo e(number_format($this->cashFlow['money_in'], 0, ',', '.')); ?></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Uang Keluar</div>
            <div class="text-xl font-extrabold text-rose-600">Rp <?php echo e(number_format($this->cashFlow['money_out'], 0, ',', '.')); ?></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Arus Kas Bersih</div>
            <div class="text-xl font-extrabold <?php echo e($this->cashFlow['net'] >= 0 ? 'text-emerald-600' : 'text-rose-600'); ?>">Rp <?php echo e(number_format(abs($this->cashFlow['net']), 0, ',', '.')); ?></div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Pendapatan vs Pengeluaran</h3>
            <canvas id="revExpChart" height="80"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Pendapatan per Metode Bayar</h3>
            <canvas id="paymentPieChart" height="80"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-900 mb-4">Rincian Metode Bayar</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100">
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">#</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Metode Bayar</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider text-right">Total</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider text-right">Kontribusi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $revenueTotal = $this->revenueByPayment->sum('total'); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->revenueByPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b border-gray-50">
                        <td class="py-3 text-gray-400"><?php echo e($i + 1); ?></td>
                        <td class="py-3 font-medium"><?php echo e($item->method); ?></td>
                        <td class="py-3 text-right">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                        <td class="py-3 text-right"><?php echo e($revenueTotal > 0 ? round(($item->total / $revenueTotal) * 100) : 0); ?>%</td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-400">Belum ada data pembayaran</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Detail Transaksi Pembayaran</h3>
            <span class="text-xs text-gray-400"><?php echo e($this->paymentsDetail->count()); ?> transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100">
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">#</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">No. Order</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Pelanggan</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Outlet</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Metode</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider text-right">Jumlah</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->paymentsDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                        <td class="py-3 text-gray-400"><?php echo e($i + 1); ?></td>
                        <td class="py-3 font-mono text-xs"><?php echo e($payment->order_number); ?></td>
                        <td class="py-3"><?php echo e($payment->customer_name ?: '-'); ?></td>
                        <td class="py-3 text-xs text-gray-500"><?php echo e($payment->outlet_name ?: '-'); ?></td>
                        <td class="py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                <?php echo e($payment->method === 'Cash' || $payment->method === 'Tunai' ? 'bg-emerald-100 text-emerald-700' : ''); ?>

                                <?php echo e($payment->method === 'QRIS' ? 'bg-indigo-100 text-indigo-700' : ''); ?>

                                <?php echo e($payment->method === 'Transfer' || $payment->method === 'Debit' ? 'bg-amber-100 text-amber-700' : ''); ?>">
                                <?php echo e($payment->method); ?>

                            </span>
                        </td>
                        <td class="py-3 text-right font-medium">Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></td>
                        <td class="py-3 text-xs text-gray-500"><?php echo e(\Carbon\Carbon::parse($payment->created_at)->format('d/m/y H:i')); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-400">Belum ada data transaksi pembayaran</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">Daftar Transaksi Order</h3>
            <span class="text-xs text-gray-400"><?php echo e($this->ordersDetail->count()); ?> order</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-100">
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">No. Order</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Tanggal</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Outlet</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Pelanggan</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider text-right">Subtotal</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider text-right">Pajak</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider text-right">Total</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Metode</th>
                        <th class="pb-3 font-semibold text-gray-500 uppercase text-xs tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->ordersDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                        <td class="py-3 font-mono text-xs font-semibold"><?php echo e($order->order_number); ?></td>
                        <td class="py-3 text-xs text-gray-500"><?php echo e($order->created_at->format('d/m/y H:i')); ?></td>
                        <td class="py-3 text-xs"><?php echo e($order->outlet?->name ?: '-'); ?></td>
                        <td class="py-3"><?php echo e($order->customer?->name ?: '-'); ?></td>
                        <td class="py-3 text-right">Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></td>
                        <td class="py-3 text-right">Rp <?php echo e(number_format($order->tax_amount, 0, ',', '.')); ?></td>
                        <td class="py-3 text-right font-semibold">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td>
                        <td class="py-3">
                            <?php $pm = $order->payments->first()?->paymentMethod?->name; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pm): ?>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                <?php echo e($pm === 'Cash' || $pm === 'Tunai' ? 'bg-emerald-100 text-emerald-700' : ''); ?>

                                <?php echo e($pm === 'QRIS' ? 'bg-indigo-100 text-indigo-700' : ''); ?>

                                <?php echo e($pm === 'Transfer' || $pm === 'Debit' ? 'bg-amber-100 text-amber-700' : ''); ?>">
                                <?php echo e($pm); ?>

                            </span>
                            <?php else: ?>
                            <span class="text-gray-400 text-xs">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                <?php echo e($order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : ''); ?>

                                <?php echo e($order->payment_status === 'partial' ? 'bg-amber-100 text-amber-700' : ''); ?>

                                <?php echo e($order->payment_status === 'unpaid' ? 'bg-red-100 text-red-700' : ''); ?>">
                                <?php echo e($order->payment_status === 'paid' ? 'Lunas' : ($order->payment_status === 'partial' ? 'Sebagian' : 'Belum')); ?>

                            </span>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="9" class="py-10 text-center text-gray-400">Belum ada data transaksi</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
(function() {
    const revEl = document.getElementById('revExpChart');
    if (revEl) {
        if (revEl._chart) revEl._chart.destroy();
        revEl._chart = new Chart(revEl.getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($this->chartLabels); ?>,
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: <?php echo json_encode($this->chartRevenue); ?>,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    },
                    {
                        label: 'Pengeluaran',
                        data: <?php echo json_encode($this->chartExpense); ?>,
                        backgroundColor: 'rgba(244, 63, 94, 0.7)',
                        borderColor: 'rgba(244, 63, 94, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20 }
                    }
                },
                scales: {
                    y: { ticks: { callback: v => 'Rp ' + (v / 1000000).toFixed(0) + 'M' } }
                }
            }
        });
    }

    const pieEl = document.getElementById('paymentPieChart');
    if (pieEl) {
        if (pieEl._chart) pieEl._chart.destroy();
        const methods = <?php echo json_encode($this->revenueByPayment->pluck('method')); ?>;
        const totals = <?php echo json_encode($this->revenueByPayment->pluck('total')->map(fn($v) => (float)$v)); ?>;
        const colors = [
            'rgba(79, 70, 229, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(168, 85, 247, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(20, 184, 166, 0.8)',
            'rgba(249, 115, 22, 0.8)',
        ];
        pieEl._chart = new Chart(pieEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: methods,
                datasets: [{
                    data: totals,
                    backgroundColor: colors.slice(0, methods.length),
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 16 }
                    }
                }
            }
        });
    }
})();
</script>
<?php /**PATH D:\project laravel\erpasia\resources\views\filament\pages\laporan-keuangan.blade.php ENDPATH**/ ?>