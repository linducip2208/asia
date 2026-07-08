<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($seoMeta['title']); ?></title>
    <meta name="description" content="<?php echo e($seoMeta['description']); ?>">
    <link rel="canonical" href="<?php echo e($seoMeta['canonical']); ?>">
    <meta property="og:title" content="<?php echo e($seoMeta['title']); ?>">
    <meta property="og:description" content="<?php echo e($seoMeta['description']); ?>">
    <meta property="og:url" content="<?php echo e($seoMeta['canonical']); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($seoMeta['title']); ?>">
    <meta name="twitter:description" content="<?php echo e($seoMeta['description']); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "itemListElement": [
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
                "@type": "ListItem",
                "position": <?php echo e($i + 1); ?>,
                "item": {
                    "@type": "Product",
                    "name": "<?php echo e($product->name); ?>",
                    "description": "<?php echo e(Str::limit($product->description, 150)); ?>",
                    "offers": {
                        "@type": "Offer",
                        "price": "<?php echo e(number_format($product->selling_price, 0, '.', '')); ?>",
                        "priceCurrency": "IDR"
                    }
                }
            }<?php if(!$loop->last): ?>,<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ]
    }
    </script>
</head>
<body class="bg-gray-50">
    <header class="bg-white border-b sticky top-0 z-50 backdrop-blur-xl bg-white/80">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="text-xl font-bold text-indigo-600">POS Retail</a>
            <nav class="space-x-4 text-sm">
                <a href="/" class="text-gray-600 hover:text-indigo-600">Beranda</a>
                <a href="/docs" class="text-gray-600 hover:text-indigo-600">Dokumentasi</a>
            </nav>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2"><?php echo e($category->name); ?> Terbaik</h1>
        <p class="text-gray-500 mb-10">Rekomendasi produk <?php echo e(strtolower($category->name)); ?> berkualitas dengan harga terbaik. Tersedia di outlet kami.</p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->isEmpty()): ?>
            <div class="text-center py-20 text-gray-400">
                <p class="text-lg">Belum ada produk di kategori ini.</p>
                <a href="/" class="mt-4 inline-block text-indigo-600 hover:underline">Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white rounded-2xl p-6 border hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">#<?php echo e($loop->iteration); ?></span>
                            <h3 class="text-lg font-bold text-gray-900 mt-2"><?php echo e($product->name); ?></h3>
                        </div>
                        <span class="text-sm font-mono text-gray-400"><?php echo e($product->sku); ?></span>
                    </div>
                    <p class="text-sm text-gray-500 mb-4"><?php echo e(Str::limit($product->description, 120)); ?></p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold text-indigo-600">Rp <?php echo e(number_format($product->selling_price, 0, ',', '.')); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->wholesale_price): ?>
                        <span class="text-sm text-gray-400 line-through">Rp <?php echo e(number_format($product->wholesale_price, 0, ',', '.')); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->current_stock <= $product->min_stock): ?>
                        <p class="text-xs text-red-500 mt-2">Stok terbatas: <?php echo e($product->current_stock); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    <footer class="text-center py-8 text-sm text-gray-400 border-t">
        POS Retail &copy; <?php echo e(date('Y')); ?>. Semua harga dapat berubah sewaktu-waktu.
    </footer>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\pseo\best-category.blade.php ENDPATH**/ ?>