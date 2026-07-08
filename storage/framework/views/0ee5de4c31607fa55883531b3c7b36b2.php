<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-extrabold text-gray-900 mb-2"><?php echo e($product->name); ?></h1>
<p class="text-gray-500 mb-4"><?php echo e($product->category->name ?? ''); ?> &bull; <?php echo e($product->brand->name ?? ''); ?></p>

<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <div class="bg-white rounded-2xl border p-6 mb-6">
            <div class="text-3xl font-extrabold text-blue-600 font-mono mb-4">Rp <?php echo e(number_format($product->selling_price, 0, ',', '.')); ?></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->wholesale_price): ?><div class="text-sm text-gray-500">Grosir: Rp <?php echo e(number_format($product->wholesale_price, 0, ',', '.')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->member_price): ?><div class="text-sm text-gray-500">Member: Rp <?php echo e(number_format($product->member_price, 0, ',', '.')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="mt-4 text-sm text-gray-600"><?php echo e($product->description); ?></div>
            <div class="mt-4 flex gap-4 text-sm text-gray-500">
                <span>SKU: <code class="font-mono bg-gray-100 px-2 py-0.5 rounded"><?php echo e($product->sku); ?></code></span>
                <span>Stok: <strong class="<?php echo e($product->current_stock > 10 ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e($product->current_stock); ?></strong></span>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($related->isNotEmpty()): ?>
        <h2 class="text-lg font-bold text-gray-800 mb-3">Produk Terkait</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <a href="/produk/<?php echo e($r->slug); ?>" class="bg-white rounded-xl border p-3 hover:border-blue-300 transition-colors">
                <div class="text-sm font-semibold"><?php echo e($r->name); ?></div>
                <div class="text-blue-600 font-bold text-sm font-mono mt-1">Rp <?php echo e(number_format($r->selling_price, 0, ',', '.')); ?></div>
            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div>
        <div class="bg-white rounded-2xl border p-4">
            <h3 class="font-semibold text-sm mb-2">Detail Produk</h3>
            <table class="w-full text-sm">
                <tr class="border-b"><td class="py-2 text-gray-500">Kategori</td><td class="py-2 font-medium"><?php echo e($product->category->name ?? '-'); ?></td></tr>
                <tr class="border-b"><td class="py-2 text-gray-500">Brand</td><td class="py-2 font-medium"><?php echo e($product->brand->name ?? '-'); ?></td></tr>
                <tr class="border-b"><td class="py-2 text-gray-500">Unit</td><td class="py-2 font-medium"><?php echo e($product->unit->name ?? '-'); ?></td></tr>
                <tr><td class="py-2 text-gray-500">Barcode</td><td class="py-2 font-mono text-xs"><?php echo e($product->barcode); ?></td></tr>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pseo._layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\project laravel\erpasia\resources\views\pseo\product-detail.blade.php ENDPATH**/ ?>