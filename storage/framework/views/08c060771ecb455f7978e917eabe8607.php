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
        "@type": "WebPage",
        "name": "<?php echo e($seoMeta['title']); ?>",
        "description": "<?php echo e($seoMeta['description']); ?>",
        "mainEntity": [
            {
                "@type": "Product",
                "name": "<?php echo e($productA->name); ?>",
                "offers": { "@type": "Offer", "price": "<?php echo e(number_format($productA->selling_price, 0, '.', '')); ?>", "priceCurrency": "IDR" }
            },
            {
                "@type": "Product",
                "name": "<?php echo e($productB->name); ?>",
                "offers": { "@type": "Offer", "price": "<?php echo e(number_format($productB->selling_price, 0, '.', '')); ?>", "priceCurrency": "IDR" }
            }
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
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2 text-center"><?php echo e($productA->name); ?> vs <?php echo e($productB->name); ?></h1>
        <p class="text-gray-500 mb-10 text-center">Perbandingan head-to-head untuk membantu Anda memilih produk yang tepat.</p>

        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white rounded-2xl p-6 border text-center">
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full mb-3 inline-block">PRODUK A</span>
                <h2 class="text-xl font-bold text-gray-900 mt-2"><?php echo e($productA->name); ?></h2>
                <p class="text-sm text-gray-500 mt-2"><?php echo e(Str::limit($productA->description, 120)); ?></p>
                <p class="text-3xl font-extrabold text-indigo-600 mt-4">Rp <?php echo e(number_format($productA->selling_price, 0, ',', '.')); ?></p>
                <div class="text-xs text-gray-400 mt-2 space-y-1">
                    <p>SKU: <?php echo e($productA->sku); ?></p>
                    <p>Kategori: <?php echo e($productA->category->name ?? '-'); ?></p>
                    <p>Brand: <?php echo e($productA->brand->name ?? '-'); ?></p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($productA->wholesale_price): ?><p>Harga Grosir: Rp <?php echo e(number_format($productA->wholesale_price, 0, ',', '.')); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border text-center">
                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-3 py-1 rounded-full mb-3 inline-block">PRODUK B</span>
                <h2 class="text-xl font-bold text-gray-900 mt-2"><?php echo e($productB->name); ?></h2>
                <p class="text-sm text-gray-500 mt-2"><?php echo e(Str::limit($productB->description, 120)); ?></p>
                <p class="text-3xl font-extrabold text-purple-600 mt-4">Rp <?php echo e(number_format($productB->selling_price, 0, ',', '.')); ?></p>
                <div class="text-xs text-gray-400 mt-2 space-y-1">
                    <p>SKU: <?php echo e($productB->sku); ?></p>
                    <p>Kategori: <?php echo e($productB->category->name ?? '-'); ?></p>
                    <p>Brand: <?php echo e($productB->brand->name ?? '-'); ?></p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($productB->wholesale_price): ?><p>Harga Grosir: Rp <?php echo e(number_format($productB->wholesale_price, 0, ',', '.')); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Tabel Perbandingan</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 font-semibold text-gray-500">Fitur</th>
                            <th class="text-center py-3 px-4 font-semibold text-indigo-600"><?php echo e($productA->name); ?></th>
                            <th class="text-center py-3 px-4 font-semibold text-purple-600"><?php echo e($productB->name); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Harga Jual</td>
                            <td class="text-center py-3 px-4">Rp <?php echo e(number_format($productA->selling_price, 0, ',', '.')); ?></td>
                            <td class="text-center py-3 px-4">Rp <?php echo e(number_format($productB->selling_price, 0, ',', '.')); ?></td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Harga Beli</td>
                            <td class="text-center py-3 px-4">Rp <?php echo e(number_format($productA->cost_price, 0, ',', '.')); ?></td>
                            <td class="text-center py-3 px-4">Rp <?php echo e(number_format($productB->cost_price, 0, ',', '.')); ?></td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Brand</td>
                            <td class="text-center py-3 px-4"><?php echo e($productA->brand->name ?? '-'); ?></td>
                            <td class="text-center py-3 px-4"><?php echo e($productB->brand->name ?? '-'); ?></td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Kategori</td>
                            <td class="text-center py-3 px-4"><?php echo e($productA->category->name ?? '-'); ?></td>
                            <td class="text-center py-3 px-4"><?php echo e($productB->category->name ?? '-'); ?></td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Stok</td>
                            <td class="text-center py-3 px-4"><?php echo e($productA->current_stock); ?></td>
                            <td class="text-center py-3 px-4"><?php echo e($productB->current_stock); ?></td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($productA->wholesale_price || $productB->wholesale_price): ?>
                        <tr class="border-b">
                            <td class="py-3 px-4 font-medium">Harga Grosir</td>
                            <td class="text-center py-3 px-4"><?php echo e($productA->wholesale_price ? 'Rp '.number_format($productA->wholesale_price, 0, ',', '.') : '-'); ?></td>
                            <td class="text-center py-3 px-4"><?php echo e($productB->wholesale_price ? 'Rp '.number_format($productB->wholesale_price, 0, ',', '.') : '-'); ?></td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
            $cheaper = $productA->selling_price <= $productB->selling_price ? $productA : $productB;
            $pricier = $productA->selling_price > $productB->selling_price ? $productA : $productB;
            $diff = abs($productA->selling_price - $productB->selling_price);
        ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($diff > 0): ?>
        <div class="bg-green-50 border border-green-100 rounded-2xl p-6 mt-6 text-center">
            <p class="text-lg font-bold text-green-700"><?php echo e($cheaper->name); ?> lebih hemat Rp <?php echo e(number_format($diff, 0, ',', '.')); ?></p>
            <p class="text-sm text-green-600 mt-1">Selisih harga <?php echo e(round(($diff / $pricier->selling_price) * 100)); ?>% dari <?php echo e($pricier->name); ?></p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    <footer class="text-center py-8 text-sm text-gray-400 border-t">
        POS Retail &copy; <?php echo e(date('Y')); ?>.
    </footer>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\pseo\compare.blade.php ENDPATH**/ ?>