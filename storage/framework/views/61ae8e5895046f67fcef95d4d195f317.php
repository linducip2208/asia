<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title><?php echo e($seoMeta['title']); ?></title>
    <meta name="description" content="<?php echo e($seoMeta['description']); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo e($seoMeta['canonical']); ?>">
    <meta property="og:title" content="<?php echo e($seoMeta['title']); ?>">
    <meta property="og:description" content="<?php echo e($seoMeta['description']); ?>">
    <meta property="og:url" content="<?php echo e($seoMeta['canonical']); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,700" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>body{font-family:Inter,sans-serif}</style>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "<?php echo e($seoMeta['schemaType'] ?? 'SoftwareApplication'); ?>",
        "name": "<?php echo e($brand); ?>",
        "applicationCategory": "PointOfSaleApplication",
        "operatingSystem": "Web",
        "description": "<?php echo e($seoMeta['description']); ?>",
        <?php if(($seoMeta['schemaType'] ?? '') === 'FAQPage'): ?>
        "mainEntity": [{
            "@type": "Question",
            "name": "Apa itu <?php echo e($brand); ?>?",
            "acceptedAnswer": { "@type": "Answer", "text": "<?php echo e($brand); ?> adalah aplikasi Point of Sale (POS) berbasis Laravel dengan source code lengkap. Multi-outlet, inventori real-time, laporan keuangan, payment gateway." }
        },{
            "@type": "Question",
            "name": "Berapa harga source code <?php echo e($brand); ?>?",
            "acceptedAnswer": { "@type": "Answer", "text": "<?php echo e($sourceCodePrice); ?> — sekali bayar lifetime. Dapat full source code, dokumentasi, dan 6 bulan support." }
        },{
            "@type": "Question",
            "name": "Fitur apa saja yang tersedia?",
            "acceptedAnswer": { "@type": "Answer", "text": "Multi-outlet, inventori real-time, barcode scanner, payment gateway (QRIS), loyalitas pelanggan, laporan keuangan, export PDF/Excel, customer portal, API integrasi, dan 40+ fitur lainnya." }
        }],
        <?php elseif(($seoMeta['schemaType'] ?? '') === 'ItemList'): ?>
        "itemListElement": [
            <?php $__currentLoopData = array_slice($features ?? [], 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            { "@type": "ListItem", "position": <?php echo e($i + 1); ?>, "name": "<?php echo e($f['name']); ?>" }<?php if(!$loop->last): ?>,<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        <?php else: ?>
        "offers": {
            "@type": "Offer",
            "price": "4999000",
            "priceCurrency": "IDR",
            "availability": "https://schema.org/InStock"
        },
        <?php endif; ?>
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "reviewCount": "127",
            "bestRating": "5"
        }
    }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white sticky top-0 z-40 shadow-lg">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="/" class="font-extrabold text-lg tracking-tight"><?php echo e($brand); ?></a>
        <div class="flex gap-4 text-sm font-medium">
            <a href="/" class="hover:text-blue-200 transition">Beranda</a>
            <a href="/docs" class="hover:text-blue-200 transition">Dokumentasi</a>
            <a href="/beli-aplikasi-pos" class="hover:text-blue-200 transition">Beli Source Code</a>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 py-10">
    <section class="bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900 text-white rounded-3xl p-8 md:p-12 mb-10 text-center">
        <h1 class="text-2xl md:text-4xl font-extrabold mb-4 leading-tight"><?php echo e($seoMeta['title']); ?></h1>
        <p class="text-blue-200 text-lg mb-8 max-w-2xl mx-auto"><?php echo e($seoMeta['description']); ?></p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/<?php echo e($waNumber); ?>?text=Halo%20saya%20tertarik%20beli%20source%20code%20<?php echo e(urlencode($brand)); ?>" target="_blank" class="px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-emerald-500/30 transition hover:-translate-y-0.5">Beli Source Code via WhatsApp &rarr;</a>
            <a href="/docs" class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-bold text-lg backdrop-blur transition border border-white/20">Lihat Dokumentasi</a>
        </div>
    </section>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-6">
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php echo e($heading); ?></h2>

                <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4 text-[15px]">
                    <?php echo $content; ?>

                </div>
            </article>
        </div>

        <div class="space-y-6">
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-2xl shadow-lg p-6 sticky top-20">
                <div class="text-4xl mb-3">💻</div>
                <h3 class="font-bold text-lg mb-2">Beli Source Code</h3>
                <p class="text-blue-100 text-sm mb-4">Full source code <strong><?php echo e($brand); ?></strong> — aplikasi POS / Point of Sale siap pakai. 1&times; bayar, lifetime.</p>
                <div class="text-2xl font-extrabold mb-4"><?php echo e($sourceCodePrice); ?></div>
                <a href="https://wa.me/<?php echo e($waNumber); ?>?text=Halo%20saya%20mau%20beli%20source%20code%20<?php echo e(urlencode($brand)); ?>" target="_blank" class="block w-full text-center py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold transition shadow-lg shadow-emerald-500/30">Chat WhatsApp Sekarang</a>
                <p class="text-blue-200 text-xs mt-3 text-center">Respon cepat · Demo lengkap · Garansi 6 bulan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wider">Kota Lainnya</h4>
                <div class="space-y-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $topCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <a href="/aplikasi-pos-<?php echo e(\Illuminate\Support\Str::slug($c['name'])); ?>" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition">Aplikasi POS <?php echo e($c['name']); ?></a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <a href="/sitemap" class="block mt-3 text-xs text-blue-600 font-semibold hover:underline">Lihat Semua Kota &rarr;</a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wider">Fitur Unggulan</h4>
                <div class="flex flex-wrap gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <a href="/aplikasi-kasir-dengan-<?php echo e(\Illuminate\Support\Str::slug($f['name'])); ?>" class="px-3 py-1.5 bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-700 rounded-full text-xs font-medium transition"><?php echo e($f['name']); ?></a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-gray-900 text-gray-400 py-10 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-6 text-sm mb-8">
            <div>
                <h4 class="font-bold text-white mb-2"><?php echo e($brand); ?></h4>
                <p>Source code aplikasi POS / Point of Sale untuk bisnis retail Indonesia.</p>
            </div>
            <div>
                <h4 class="font-bold text-white mb-2">Link</h4>
                <ul class="space-y-1">
                    <li><a href="/beli-aplikasi-pos" class="hover:text-white transition">Beli Source Code</a></li>
                    <li><a href="/docs" class="hover:text-white transition">Dokumentasi</a></li>
                    <li><a href="/sitemap" class="hover:text-white transition">Sitemap</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-2">Kontak</h4>
                <p>WA: <?php echo e(substr($waNumber, 2)); ?></p>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-6 text-center text-xs">&copy; <?php echo e(date('Y')); ?> <?php echo e($brand); ?>. Source code aplikasi Point of Sale.</div>
    </div>
</footer>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\pseo\generic.blade.php ENDPATH**/ ?>