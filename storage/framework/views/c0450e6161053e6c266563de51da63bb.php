<?php
$typeLabels = [
    'home' => 'Halaman Utama',
    'product' => 'Halaman Produk',
    'category' => 'Kategori',
    'brand' => 'Brand',
    'best-category' => 'Produk Terbaik per Kategori',
    'best-category-year' => 'Produk Terbaik per Tahun',
    'alternatives' => 'Alternatif Produk',
    'compare' => 'Perbandingan Produk',
    'price-list' => 'Daftar Harga',
    'guide' => 'Panduan & Tips',
    'store-location' => 'Lokasi Toko',
    'docs' => 'Dokumentasi',
    'pos' => 'POS',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap — <?php echo e($totalPages); ?>+ Halaman | POS Retail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|jetbrains-mono:400,700" rel="stylesheet">
    <style>body{font-family:Inter, sans-serif; background:#f8fafc}</style>
</head>
<body class="p-6 max-w-5xl mx-auto">
    <div class="mb-8">
        <a href="/" class="text-blue-600 hover:text-blue-800 text-sm">&larr; Kembali ke Beranda</a>
        <h1 class="text-3xl font-extrabold text-gray-900 mt-2">Sitemap</h1>
        <p class="text-gray-500 mt-1"><?php echo e($totalPages); ?>+ halaman terindeks untuk SEO</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $pages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <div class="mb-8">
        <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-xs font-semibold uppercase"><?php echo e($typeLabels[$type] ?? $type); ?></span>
            <span class="text-sm text-gray-400 font-normal"><?php echo e(count($pages)); ?> halaman</span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <a href="<?php echo e($page['url']); ?>" class="block bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-700 hover:border-blue-300 hover:text-blue-700 hover:shadow-sm transition-all truncate" title="<?php echo e($page['title']); ?>">
                <?php echo e(Str::limit($page['title'], 60)); ?>

            </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    <div class="text-center text-sm text-gray-400 py-8 border-t mt-8">
        Sitemap ini di-generate otomatis setiap 24 jam. Terakhir update: <?php echo e(now()->format('d M Y H:i')); ?> WIB
    </div>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\pseo\sitemap.blade.php ENDPATH**/ ?>