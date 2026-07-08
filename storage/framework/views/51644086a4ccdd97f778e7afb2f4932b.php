<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-extrabold text-gray-900 mb-1"><?php echo e($category->name); ?></h1>
<p class="text-gray-500 mb-6"><?php echo e($category->description); ?></p>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <a href="/produk/<?php echo e($p->slug); ?>" class="bg-white rounded-xl border p-4 hover:border-blue-300 hover:shadow-sm transition-all">
        <div class="text-sm font-semibold text-gray-800 line-clamp-2"><?php echo e($p->name); ?></div>
        <div class="text-blue-600 font-bold mt-2 font-mono">Rp <?php echo e(number_format($p->selling_price, 0, ',', '.')); ?></div>
        <div class="text-xs text-gray-400 mt-1">Stok: <?php echo e($p->current_stock); ?></div>
    </a>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>
<?php echo e($products->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pseo._layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\project laravel\erpasia\resources\views\pseo\category-page.blade.php ENDPATH**/ ?>