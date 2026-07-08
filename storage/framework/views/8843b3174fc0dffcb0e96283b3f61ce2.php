<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($seoMeta['title']); ?></title>
    <meta name="description" content="<?php echo e($seoMeta['description']); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo e(config('app.url')); ?>/docs">
    <meta property="og:title" content="<?php echo e($seoMeta['title']); ?>">
    <meta property="og:description" content="<?php echo e($seoMeta['description']); ?>">
    <meta property="og:url" content="<?php echo e(config('app.url')); ?>/docs">
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#3b82f6">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,700" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['Inter','sans-serif'],mono:['JetBrains Mono','monospace']}}}}</script>
    <script type="application/ld+json"><?php echo json_encode(['@context' => 'https://schema.org', '@type' => 'Article', 'headline' => $seoMeta['title'], 'description' => $seoMeta['description'], 'inLanguage' => 'id']); ?></script>
    <style>
        html{scroll-behavior:smooth}
        .gradient-hero{background:linear-gradient(160deg,#0c1d4a 0%,#1e3a8a 20%,#1e40af 40%,#2563eb 60%,#3b82f6 80%,#60a5fa 100%)}
        .browser-mock{border-radius:10px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,0.12);border:1px solid #e2e8f0;transition:transform 0.2s}
        .browser-mock:hover{transform:translateY(-2px);box-shadow:0 12px 48px rgba(0,0,0,0.15)}
        .browser-mock-header{background:#f1f5f9;padding:8px 12px;display:flex;align-items:center;gap:6px;border-bottom:1px solid #e2e8f0}
        .browser-dot{width:10px;height:10px;border-radius:50%}
        .browser-dot.red{background:#ef4444}.browser-dot.yellow{background:#f59e0b}.browser-dot.green{background:#22c55e}
        .browser-url{background:#e2e8f0;border-radius:4px;padding:2px 8px;font-size:10px;font-family:'JetBrains Mono',monospace;color:#64748b;flex:1;text-align:center;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
        .jump-nav{backdrop-filter:blur(12px);background:rgba(255,255,255,0.94);border-bottom:1px solid #e2e8f0}
        .step-num{width:28px;height:28px;min-width:28px;border-radius:50%;background:#dbeafe;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700}
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

<nav class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M3 9l1.5-5h15L21 9v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9Z"/><path d="M3 9h18"/><path d="M9 22V11h6v11"/></svg>
            <span class="font-bold text-lg">POS Retail</span>
        </a>
        <div class="hidden md:flex items-center gap-6 text-sm font-medium">
            <a href="/" class="text-gray-600 hover:text-blue-600">Beranda</a>
            <a href="/docs" class="text-blue-600 font-semibold">Dokumentasi</a>
            <a href="/admin/login" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Login Admin</a>
        </div>
    </div>
</nav>

<div class="jump-nav sticky z-40 overflow-x-auto" style="top:64px">
    <div class="max-w-7xl mx-auto px-4 py-2.5">
        <div class="flex gap-1.5 text-xs font-medium whitespace-nowrap">
            <a href="#demo" class="px-3 py-1.5 rounded-md hover:bg-blue-50 text-gray-600">Akun Demo</a>
            <a href="#menu" class="px-3 py-1.5 rounded-md hover:bg-blue-50 text-gray-600">Struktur Menu</a>
            <a href="#tutorial" class="px-3 py-1.5 rounded-md hover:bg-blue-50 text-gray-600">Tutorial</a>
            <a href="#features" class="px-3 py-1.5 rounded-md hover:bg-blue-50 text-gray-600">Fitur</a>
        </div>
    </div>
</div>

<section class="gradient-hero text-white py-14 px-4 text-center">
    <h1 class="text-3xl md:text-5xl font-extrabold mb-3">Dokumentasi POS Retail</h1>
    <p class="text-lg text-blue-200 max-w-2xl mx-auto">Panduan lengkap sistem kasir modern. Tutorial step-by-step, screenshot tiap menu, dan penjelasan semua fitur.</p>
    <div class="flex justify-center gap-4 mt-6">
        <a href="/admin/login" class="px-6 py-2.5 bg-white text-blue-700 rounded-xl font-bold hover:bg-blue-50">Login Admin</a>
        <a href="/pos" class="px-6 py-2.5 border-2 border-white/30 rounded-xl font-bold hover:bg-white/10">Buka POS</a>
    </div>
</section>

<section id="demo" class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Akun Demo — 5 Role</h2>
        <p class="text-gray-500 mb-6">Password semua akun: <code class="bg-gray-100 px-2 py-0.5 rounded font-mono text-sm">password</code></p>
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-left">
                <thead><tr class="bg-gray-50"><th class="py-3 px-4 text-xs font-bold uppercase text-gray-500">Role</th><th class="py-3 px-4 text-xs font-bold uppercase text-gray-500">Email</th><th class="py-3 px-4 text-xs font-bold uppercase text-gray-500">Password</th><th class="py-3 px-4 text-xs font-bold uppercase text-gray-500">Cakupan</th></tr></thead>
                <tbody class="text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $demoAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-t border-gray-100 hover:bg-blue-50/30">
                        <td class="py-3 px-4 font-semibold"><span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold"><?php echo e($a['role']); ?></span></td>
                        <td class="py-3 px-4 font-mono text-gray-700 text-xs"><?php echo e($a['email']); ?></td>
                        <td class="py-3 px-4 font-mono text-gray-700 text-xs"><?php echo e($a['password']); ?></td>
                        <td class="py-3 px-4 text-gray-500 text-xs"><?php echo e($a['scope']); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section id="menu" class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-6">Struktur Menu Admin</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="bg-white rounded-xl p-5 border shadow-sm">
                <h3 class="font-bold text-gray-900 mb-3"><?php echo e($f['group']); ?></h3>
                <ul class="space-y-1.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $f['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li class="text-sm text-gray-600 flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span><?php echo e($item['title']); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>

<section id="tutorial" class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Tutorial Langkah demi Langkah</h2>
        <p class="text-gray-500 mb-10">Ikuti tutorial berikut untuk menguasai seluruh alur bisnis POS Retail dari setup awal hingga integrasi.</p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tutorial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="mb-10 border border-gray-200 rounded-2xl p-6 md:p-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center font-bold text-blue-600 text-lg"><?php echo e($phase['phase']); ?></div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-blue-600">Fase <?php echo e($phase['phase']); ?></span>
                    <h3 class="text-lg font-bold text-gray-900"><?php echo e($phase['title']); ?></h3>
                </div>
            </div>
            <div class="space-y-2.5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $phase['steps']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="flex items-start gap-3 text-gray-700 text-sm">
                    <span class="step-num"><?php echo e($loop->iteration); ?></span>
                    <span class="pt-0.5"><?php echo $step; ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</section>

<section id="features" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2 text-center">Fitur Lengkap dengan Screenshot</h2>
        <p class="text-center text-gray-500 max-w-2xl mx-auto mb-14">Setiap menu dijelaskan dengan screenshot tampilan asli aplikasi.</p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="mb-16">
            <h3 class="text-xl font-bold text-gray-900 mb-8"><?php echo e($loop->iteration); ?>. <?php echo e($feature['group']); ?></h3>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $feature['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="flex flex-col <?php echo e($idx % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'); ?> items-center gap-8 mb-12">
                <div class="md:w-1/2">
                    <div class="browser-mock">
                        <div class="browser-mock-header">
                            <div class="browser-dot red"></div><div class="browser-dot yellow"></div><div class="browser-dot green"></div>
                            <div class="browser-url">pos-retail/admin/<?php echo e($item['screenshot'] ?? 'dashboard'); ?></div>
                        </div>
                        <img src="/marketing/screens/<?php echo e($item['screenshot'] ?? 'dashboard'); ?>.png" alt="<?php echo e($item['title']); ?>" class="w-full" loading="lazy" onerror="this.style.display='none'">
                    </div>
                </div>
                <div class="md:w-1/2">
                    <h4 class="text-lg font-bold text-gray-900 mb-2"><?php echo e($item['title']); ?></h4>
                    <p class="text-gray-600 mb-3 text-sm leading-relaxed"><?php echo e($item['desc']); ?></p>
                    <ul class="space-y-1.5 text-sm text-gray-600">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item['bullets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li class="flex items-start gap-2"><span class="text-blue-500 mt-1">&#x2022;</span><?php echo e($bullet); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</section>

<section class="gradient-hero py-16 text-white text-center">
    <h2 class="text-2xl md:text-3xl font-extrabold mb-4">Siap Mencoba POS Retail?</h2>
    <p class="text-blue-200 text-lg mb-8">Login dengan akun demo dan eksplorasi semua fitur.</p>
    <div class="flex justify-center gap-4">
        <a href="/admin/login" class="px-8 py-3.5 bg-white text-blue-700 rounded-xl font-bold text-lg hover:bg-blue-50 shadow-lg">Login Admin</a>
        <a href="/" class="px-8 py-3.5 border-2 border-white/30 rounded-xl font-bold text-lg hover:bg-white/10">Beranda</a>
    </div>
</section>

<footer class="bg-gray-900 text-gray-400 py-10 text-center text-sm">
    <div class="max-w-6xl mx-auto px-4">
        <div class="font-bold text-white text-lg mb-2">POS Retail</div>
        <p>&copy; <?php echo e(date('Y')); ?> POS Retail. Seluruh hak cipta dilindungi.</p>
        <div class="flex justify-center gap-6 mt-3"><a href="/" class="hover:text-white">Beranda</a><a href="/sitemap" class="hover:text-white">Sitemap</a></div>
    </div>
</footer>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views/pseo/docs-index.blade.php ENDPATH**/ ?>