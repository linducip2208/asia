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

    <div class="space-y-6">
        <form wire:submit="save" class="space-y-6">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white"><?php echo e($editId ? 'Edit Webhook' : 'Tambah Webhook'); ?></h3>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Webhook</label>
                        <input type="text" wire:model="editingName" maxlength="100" placeholder="Notifikasi Order" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Event</label>
                        <select wire:model="editingEvent" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">URL Endpoint</label>
                        <input type="url" wire:model="editingUrl" maxlength="255" placeholder="https://example.com/webhook/receive" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Secret Key</label>
                        <input type="password" wire:model="editingSecretKey" maxlength="255" placeholder="Untuk verifikasi signature" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <input type="checkbox" wire:model="editingIsActive" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            Aktif
                        </label>
                    </div>
                </div>
                <div class="px-6 pb-4 flex gap-2">
                    <button type="submit" wire:loading.attr="disabled" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-5 py-2.5 text-sm shadow-sm bg-primary-600 text-white hover:bg-primary-500">
                        <span wire:loading.remove><?php echo e($editId ? 'Update' : 'Simpan'); ?></span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editId): ?>
                    <button type="button" wire:click="resetForm" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-5 py-2.5 text-sm shadow-sm bg-gray-500 text-white hover:bg-gray-400">Batal</button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </form>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Daftar Webhook</h3>
            </div>
            <div class="fi-section-content p-6 pt-0">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($webhooks)): ?>
                    <p class="text-gray-500 text-sm">Belum ada webhook terdaftar.</p>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Nama</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Event</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">URL</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Status</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $webhooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $webhook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-3 py-3"><?php echo e($webhook['name']); ?></td>
                                <td class="px-3 py-3"><span class="text-xs font-mono bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded"><?php echo e($webhook['api_format']); ?></span></td>
                                <td class="px-3 py-3 text-xs text-gray-500 max-w-xs truncate"><?php echo e($webhook['base_url']); ?></td>
                                <td class="px-3 py-3">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium <?php echo e($webhook['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'); ?>">
                                        <?php echo e($webhook['is_active'] ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex gap-1">
                                        <button type="button" wire:click="edit(<?php echo e($webhook['id']); ?>)" class="text-primary-600 hover:text-primary-800 text-xs underline">Edit</button>
                                        <button type="button" wire:click="delete(<?php echo e($webhook['id']); ?>)" wire:confirm="Hapus webhook ini?" class="text-red-600 hover:text-red-800 text-xs underline">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
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
<?php /**PATH D:\project laravel\erpasia\resources\views\filament\pages\integrasi\webhook.blade.php ENDPATH**/ ?>