<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <form wire:submit="save">
        <div class="space-y-6">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Informasi Perusahaan</h3>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Perusahaan</label>
                        <input type="text" wire:model="company_name" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                        <textarea wire:model="address" rows="2" maxlength="500" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border"></textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" wire:model="phone" maxlength="50" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" wire:model="email" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
                        <input type="url" wire:model="website" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">NPWP</label>
                        <input type="text" wire:model="npwp" maxlength="30" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Teks Footer Invoice / Dokumen</label>
                        <input type="text" wire:model="footer_text" maxlength="255" placeholder="Terima kasih atas kepercayaan Anda." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                </div>
            </div>

            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Logo Perusahaan</h3>
                </div>
                <div class="fi-section-content p-6 pt-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($current_logo): ?>
                    <div class="mb-3 flex items-center gap-3">
                        <img src="<?php echo e(asset('storage/' . $current_logo)); ?>" class="h-16 border rounded p-1">
                        <button type="button" wire:click="deleteLogo" wire:confirm="Hapus logo?" class="text-red-600 hover:text-red-800 text-sm underline">Hapus</button>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div>
                        <input type="file" wire:model="logo" accept="image/png,image/jpg,image/jpeg,image/gif,image/svg+xml" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border text-sm">
                        <p class="text-xs text-gray-500 mt-1">Maks 2MB. Direkomendasikan 200x60px (PNG transparan).</p>
                        <div wire:loading wire:target="logo" class="text-xs text-primary-600 mt-1">Uploading...</div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-6 py-3 text-base shadow-sm bg-primary-600 text-white hover:bg-primary-500 dark:bg-primary-500 dark:hover:bg-primary-400">
                    <span wire:loading.remove>Simpan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </div>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH D:\project laravel\erpasia\resources\views\filament\pages\pengaturan\profil.blade.php ENDPATH**/ ?>