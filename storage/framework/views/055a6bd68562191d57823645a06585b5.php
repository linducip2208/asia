<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0 0 5px 0; color: #1e293b; }
        .header p { font-size: 11px; color: #64748b; margin: 0; }
        .summary { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .summary-card { border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 16px; flex: 1; min-width: 130px; }
        .summary-card .label { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .summary-card .value { font-size: 16px; font-weight: bold; color: #1e293b; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #f1f5f9; color: #475569; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 10px; text-align: left; border-bottom: 2px solid #e2e8f0; }
        td { padding: 6px 10px; border-bottom: 1px solid #f1f5f9; font-size: 10px; color: #334155; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { font-size: 8px; color: #94a3b8; text-align: center; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>Periode: <?php echo e(\Carbon\Carbon::parse($startDate)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('d M Y')); ?></p>
    </div>

    <div class="summary">
        <div class="summary-card">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pesanan</div>
            <div class="value"><?php echo e($totalOrders); ?></div>
        </div>
        <div class="summary-card">
            <div class="label">Rata-rata Pesanan</div>
            <div class="value">Rp <?php echo e(number_format($avgOrder, 0, ',', '.')); ?></div>
        </div>
        <div class="summary-card">
            <div class="label">Total Diskon</div>
            <div class="value">Rp <?php echo e(number_format($totalDiscount, 0, ',', '.')); ?></div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pajak</div>
            <div class="value">Rp <?php echo e(number_format($totalTax, 0, ',', '.')); ?></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Tanggal</th>
                <th>Outlet</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th class="text-right">Subtotal</th>
                <th class="text-right">Diskon</th>
                <th class="text-right">Pajak</th>
                <th class="text-right">Total</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td><?php echo e($order->order_number); ?></td>
                <td><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
                <td><?php echo e($order->outlet->name ?? '-'); ?></td>
                <td><?php echo e($order->user->name ?? '-'); ?></td>
                <td><?php echo e($order->customer->name ?? 'Walk-in'); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($order->discount_amount, 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($order->tax_amount, 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td>
                <td class="text-center"><?php echo e($order->payment_status); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="10" style="text-align: center; padding: 20px;">Tidak ada data penjualan pada periode ini.</td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan digenerate pada <?php echo e(now()->format('d M Y H:i:s')); ?> oleh <?php echo e(auth()->user()?->name ?? 'System'); ?></p>
        <p>POS Retail &copy; <?php echo e(date('Y')); ?></p>
    </div>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\pdf\laporan-penjualan.blade.php ENDPATH**/ ?>