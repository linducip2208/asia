<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($seoTitle ?? $post->title . ' — ' . config('app.name')); ?></title>
    <meta name="description" content="<?php echo e($seoDescription ?? $post->excerpt); ?>">
    <meta property="og:title" content="<?php echo e($seoTitle ?? $post->title); ?>">
    <meta property="og:description" content="<?php echo e($seoDescription ?? $post->excerpt); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo e(route('blog.show', $post->slug)); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->featured_image): ?>
        <meta property="og:image" content="<?php echo e(asset($post->featured_image)); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <script type="application/ld+json"><?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:400,500,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe',
                            300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af',
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="font-sans bg-stone-50 text-slate-800 antialiased">
    
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 font-bold text-xl text-slate-900">
                <span class="text-2xl">🏪</span> <?php echo e(config('app.name')); ?>

            </a>
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('home')); ?>" class="text-sm text-slate-600 hover:text-blue-600 transition">Beranda</a>
                <a href="<?php echo e(route('blog.index')); ?>" class="text-sm text-blue-600 font-semibold">Blog</a>
                <a href="/docs" class="text-sm text-slate-600 hover:text-blue-600 transition">Dokumentasi</a>
                <a href="<?php echo e(route('login')); ?>" class="text-sm px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Masuk</a>
            </div>
        </div>
    </nav>

    
    <section class="bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900 text-white py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <a href="<?php echo e(route('blog.category', $post->category?->slug ?? '#')); ?>" class="inline-block text-xs bg-white/20 backdrop-blur text-white px-3 py-1 rounded-full font-semibold uppercase tracking-wider mb-4">
                <?php echo e($post->category?->name ?? 'Umum'); ?>

            </a>
            <h1 class="text-3xl lg:text-4xl font-extrabold mb-4 leading-tight"><?php echo e($post->title); ?></h1>
            <div class="flex items-center justify-center gap-3 text-blue-200 text-sm">
                <span><?php echo e($post->author?->name ?? config('app.name')); ?></span>
                <span>&middot;</span>
                <span><?php echo e($post->published_at?->format('d M Y')); ?></span>
            </div>
        </div>
    </section>

    
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->featured_image): ?>
                    <img src="<?php echo e(asset($post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full rounded-2xl mb-8 shadow-lg">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <article class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 lg:p-12">
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-[15px]">
                        <?php echo $post->content; ?>

                    </div>
                </article>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedPosts->count()): ?>
                    <div class="mt-10">
                        <h3 class="text-xl font-bold text-slate-900 mb-6">Artikel Terkait</h3>
                        <div class="grid md:grid-cols-3 gap-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <a href="<?php echo e(route('blog.show', $rp->slug)); ?>" class="group bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md hover:-translate-y-1 transition">
                                    <h4 class="font-semibold text-sm group-hover:text-blue-600 transition line-clamp-2"><?php echo e($rp->title); ?></h4>
                                    <span class="text-xs text-slate-400 mt-2 block"><?php echo e($rp->published_at?->format('d M Y')); ?></span>
                                </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <h4 class="font-bold text-sm uppercase tracking-wider text-slate-500 mb-4">Kategori</h4>
                    <div class="space-y-1">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <a href="<?php echo e(route('blog.category', $cat->slug)); ?>"
                               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm hover:bg-blue-50 hover:text-blue-600 transition <?php echo e($post->category_id == $cat->id ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600'); ?>">
                                <span><?php echo e($cat->name); ?></span>
                                <span class="text-xs bg-slate-100 px-2 py-0.5 rounded-full"><?php echo e($cat->posts_count); ?></span>
                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <h4 class="font-bold text-sm uppercase tracking-wider text-slate-500 mb-4">Terbaru</h4>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <a href="<?php echo e(route('blog.show', $rp->slug)); ?>" class="block group">
                                <h5 class="text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition line-clamp-2"><?php echo e($rp->title); ?></h5>
                                <span class="text-xs text-slate-400"><?php echo e($rp->published_at?->format('d M Y')); ?></span>
                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-lg p-6 text-white text-center">
                    <div class="text-4xl mb-3">💻</div>
                    <h4 class="font-bold mb-2">Butuh Aplikasi POS?</h4>
                    <p class="text-sm text-blue-100 mb-4">Source code POS Retail siap pakai. Integrasi payment gateway, inventori, laporan lengkap.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-block w-full py-2.5 bg-white text-blue-700 rounded-xl font-semibold text-sm hover:bg-blue-50 transition">
                        Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <footer class="bg-slate-900 text-slate-400 py-10 text-sm">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?> &middot; Powered by Laravel</p>
        </div>
    </footer>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\blog\show.blade.php ENDPATH**/ ?>