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
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Pilih Provider Pembayaran</h3>
                </div>
                <div class="fi-section-content p-6 pt-0">
                    <div class="flex gap-2 flex-wrap">
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="selected_provider" value="midtrans" class="sr-only peer">
                            <span class="px-4 py-2 rounded-lg border text-sm font-medium peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition">Midtrans</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="selected_provider" value="xendit" class="sr-only peer">
                            <span class="px-4 py-2 rounded-lg border text-sm font-medium peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition">Xendit</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="selected_provider" value="qris" class="sr-only peer">
                            <span class="px-4 py-2 rounded-lg border text-sm font-medium peer-checked:bg-primary-600 peer-checked:text-white peer-checked:border-primary-600 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition">QRIS</span>
                        </label>
                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selected_provider === 'midtrans'): ?>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Konfigurasi Midtrans</h3>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Server Key</label>
                        <input type="password" wire:model="midtrans_server_key" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Client Key</label>
                        <input type="password" wire:model="midtrans_client_key" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Merchant ID</label>
                        <input type="text" wire:model="midtrans_merchant_id" maxlength="100" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div class="flex items-end gap-6">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <input type="checkbox" wire:model="midtrans_is_production" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            Production Mode
                        </label>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <input type="checkbox" wire:model="midtrans_is_active" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            Aktif
                        </label>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selected_provider === 'xendit'): ?>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Konfigurasi Xendit</h3>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">API Key</label>
                        <input type="password" wire:model="xendit_api_key" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Callback Token</label>
                        <input type="text" wire:model="xendit_callback_token" maxlength="255" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <input type="checkbox" wire:model="xendit_is_active" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            Aktif
                        </label>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selected_provider === 'qris'): ?>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Konfigurasi QRIS</h3>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Merchant</label>
                        <input type="text" wire:model="qris_merchant_name" maxlength="100" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Terminal ID</label>
                        <input type="text" wire:model="qris_terminal_id" maxlength="100" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tipe QRIS</label>
                        <select wire:model="qris_type" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                            <option value="static">Static QR</option>
                            <option value="dynamic">Dynamic QR</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
<?php /**PATH D:\project laravel\erpasia\resources\views\filament\pages\integrasi\payment.blade.php ENDPATH**/ ?>