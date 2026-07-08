<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Portal Pelanggan'); ?> — POS Retail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <header class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('portal.index')); ?>" class="text-lg font-bold text-indigo-600">POS Retail</a>
            <div class="flex items-center gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
                    <span class="text-sm text-gray-600"><?php echo e(auth('customer')->user()->name); ?></span>
                    <form action="<?php echo e(route('portal.logout')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-sm text-gray-400 hover:text-red-500 transition">
                            Keluar
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="border-t border-gray-200 mt-16">
        <div class="max-w-4xl mx-auto px-4 py-6 text-center text-xs text-gray-400">
            &copy; <?php echo e(date('Y')); ?> POS Retail. Seluruh hak cipta dilindungi.
        </div>
    </footer>

</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\portal\layout.blade.php ENDPATH**/ ?>