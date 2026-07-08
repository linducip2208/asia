<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Daftar — ERPAsia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif}</style>
</head>
<body class="h-full flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Daftar ERPAsia</h1>
            <p class="mt-2 text-gray-500">Mulai kelola bisnis retail Anda dalam 2 menit.</p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"><?php echo e($errors->first()); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <form method="POST" action="<?php echo e(route('tenant.register')); ?>" class="bg-white shadow rounded-xl p-8 space-y-5">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Bisnis</label>
                <input name="business_name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border" placeholder="Toko Berkah Jaya">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Subdomain</label>
                <div class="mt-1 flex rounded-lg shadow-sm"><span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">https://</span><input name="slug" required class="flex-1 block w-full rounded-none rounded-r-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border" placeholder="tokoberkah">.erpasia.test</div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-semibold text-gray-700">Email Bisnis</label><input name="email" type="email" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border"></div>
                <div><label class="block text-sm font-semibold text-gray-700">Telepon</label><input name="phone" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border" placeholder="0812xxxx"></div>
            </div>
            <hr>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Anda</label>
                <input name="name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border" placeholder="Nama pemilik/admin">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Email Login</label>
                <input name="user_email" type="email" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Password</label>
                <input name="password" type="password" required minlength="8" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                <input name="password_confirmation" type="password" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700">Paket</label>
                <select name="plan_slug" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 border">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($plan->slug); ?>" <?php if($plan->slug === 'free'): ?> selected <?php endif; ?>><?php echo e($plan->name); ?> — <?php echo e($plan->formattedPriceMonthly()); ?>/bulan</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow transition">Daftar Sekarang</button>
            <p class="text-center text-sm text-gray-500">Sudah punya akun? <a href="/admin/login" class="text-blue-600 font-semibold hover:underline">Masuk</a></p>
        </form>
    </div>
</body>
</html>
<?php /**PATH D:\project laravel\erpasia\resources\views\tenant\register.blade.php ENDPATH**/ ?>