<?php $__env->startSection('title', $order->order_number); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-processed { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    .payment-paid { background: #d1fae5; color: #065f46; }
    .payment-partial { background: #fef3c7; color: #92400e; }
    .payment-unpaid { background: #fee2e2; color: #991b1b; }

    @media print {
        body { background: white; }
        .no-print { display: none !important; }
        header { border-bottom: 1px solid #e5e7eb !important; background: white !important; }
        main { max-width: 100% !important; padding: 0 !important; }
        footer { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6 no-print">
        <a href="<?php echo e(route('portal.index')); ?>" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
            </svg>
            Cetak
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6 card">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900"><?php echo e($order->order_number); ?></h1>
                <p class="text-sm text-gray-400 mt-0.5"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                    <?php switch($order->order_status):
                        case ('pending'): ?> status-pending <?php break; ?>
                        <?php case ('processed'): ?> status-processed <?php break; ?>
                        <?php case ('completed'): ?> status-completed <?php break; ?>
                        <?php case ('cancelled'): ?> status-cancelled <?php break; ?>
                        <?php default: ?> bg-gray-100 text-gray-600
                    <?php endswitch; ?>
                ">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($order->order_status):
                        case ('pending'): ?> Pending <?php break; ?>
                        <?php case ('processed'): ?> Diproses <?php break; ?>
                        <?php case ('completed'): ?> Selesai <?php break; ?>
                        <?php case ('cancelled'): ?> Dibatalkan <?php break; ?>
                        <?php default: ?> <?php echo e($order->order_status); ?>

                    <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                    <?php switch($order->payment_status):
                        case ('paid'): ?> payment-paid <?php break; ?>
                        <?php case ('partial'): ?> payment-partial <?php break; ?>
                        <?php case ('unpaid'): ?> payment-unpaid <?php break; ?>
                        <?php default: ?> bg-gray-100 text-gray-600
                    <?php endswitch; ?>
                ">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($order->payment_status):
                        case ('paid'): ?> Lunas <?php break; ?>
                        <?php case ('partial'): ?> DP <?php break; ?>
                        <?php case ('unpaid'): ?> Belum Bayar <?php break; ?>
                        <?php default: ?> <?php echo e($order->payment_status); ?>

                    <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->outlet): ?>
                <div>
                    <p class="text-gray-400 mb-0.5">Outlet</p>
                    <p class="font-medium text-gray-700"><?php echo e($order->outlet->name); ?></p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div>
                <p class="text-gray-400 mb-0.5">Tipe</p>
                <p class="font-medium text-gray-700"><?php echo e($order->order_type ?? '-'); ?></p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->queue_number): ?>
                <div>
                    <p class="text-gray-400 mb-0.5">No. Antrian</p>
                    <p class="font-medium text-gray-700"><?php echo e($order->queue_number); ?></p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->order_notes): ?>
                <div class="col-span-2 sm:col-span-4">
                    <p class="text-gray-400 mb-0.5">Catatan</p>
                    <p class="font-medium text-gray-700"><?php echo e($order->order_notes); ?></p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Item Pesanan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Qty</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="px-6 py-3">
                                <p class="font-medium text-gray-900"><?php echo e($item->product?->name ?? 'Produk #'.$item->product_id); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->productVariant): ?>
                                    <p class="text-xs text-gray-400 mt-0.5"><?php echo e($item->productVariant->name); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->discount_percent > 0 || $item->discount_amount > 0): ?>
                                    <p class="text-xs text-red-500 mt-0.5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->discount_percent > 0): ?>
                                            Diskon <?php echo e(number_format($item->discount_percent, 1)); ?>%
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->discount_amount > 0): ?>
                                            -Rp <?php echo e(number_format($item->discount_amount, 0, ',', '.')); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600"><?php echo e($item->quantity); ?></td>
                            <td class="px-4 py-3 text-right text-gray-600">Rp <?php echo e(number_format($item->unit_price, 0, ',', '.')); ?></td>
                            <td class="px-6 py-3 text-right font-medium text-gray-900">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 card">
            <h2 class="text-sm font-semibold text-gray-900 mb-4">Ringkasan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium text-gray-700">Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->discount_amount > 0): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Diskon</span>
                        <span class="font-medium text-red-500">-Rp <?php echo e(number_format($order->discount_amount, 0, ',', '.')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tax_amount > 0): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pajak</span>
                        <span class="font-medium text-gray-700">Rp <?php echo e(number_format($order->tax_amount, 0, ',', '.')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="flex justify-between border-t border-gray-100 pt-2 mt-2">
                    <span class="font-semibold text-gray-900">Total</span>
                    <span class="font-bold text-gray-900 text-base">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->deposit_amount > 0): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Uang Muka</span>
                        <span class="font-medium text-gray-700">Rp <?php echo e(number_format($order->deposit_amount, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Sisa</span>
                        <span class="font-medium text-orange-600">Rp <?php echo e(number_format($order->remaining_amount, 0, ',', '.')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 card">
            <h2 class="text-sm font-semibold text-gray-900 mb-4">Pembayaran</h2>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payments->isNotEmpty()): ?>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <p class="font-medium text-gray-700"><?php echo e($payment->paymentMethod?->name ?? 'Pembayaran #'.$payment->id); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->reference_number): ?>
                                    <p class="text-xs text-gray-400"><?php echo e($payment->reference_number); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->paid_at): ?>
                                    <p class="text-xs text-gray-400"><?php echo e($payment->paid_at->format('d M Y, H:i')); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <span class="font-semibold text-gray-900">Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-400">Belum ada pembayaran.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->is_installment): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6 card">
            <h2 class="text-sm font-semibold text-gray-900 mb-3">Cicilan</h2>
            <p class="text-sm text-gray-500">
                Periode: <?php echo e($order->installment_period); ?> &middot; <?php echo e($order->installment_count); ?>x cicilan
            </p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('portal.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\project laravel\erpasia\resources\views\portal\order-detail.blade.php ENDPATH**/ ?>