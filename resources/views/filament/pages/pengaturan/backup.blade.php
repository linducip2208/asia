<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between gap-4">
            <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Backup Database</h3>
            <div class="flex gap-2">
                <button type="button" wire:click="createBackup" wire:loading.attr="disabled" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-5 py-2.5 text-sm shadow-sm bg-primary-600 text-white hover:bg-primary-500">
                    <span wire:loading.remove wire:target="createBackup">Backup Sekarang</span>
                    <span wire:loading wire:target="createBackup">Mem-backup...</span>
                </button>
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Riwayat Backup</h3>
            </div>
            <div class="fi-section-content p-6 pt-0">
                @if(empty($backups))
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-sm mb-2">Belum ada file backup.</p>
                        <p class="text-gray-400 text-xs">Klik "Backup Sekarang" untuk membuat backup pertama.</p>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Nama File</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Ukuran</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Tanggal</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-3 py-3 font-mono text-xs">{{ $backup['name'] }}</td>
                                <td class="px-3 py-3 text-xs">{{ $backup['size'] }}</td>
                                <td class="px-3 py-3 text-xs text-gray-500">{{ $backup['date'] }}</td>
                                <td class="px-3 py-3">
                                    <div class="flex gap-2">
                                        <a href="#" wire:click.prevent="downloadBackup('{{ $backup['name'] }}')" class="text-primary-600 hover:text-primary-800 text-xs underline">Download</a>
                                        <button type="button" wire:click="deleteBackup('{{ $backup['name'] }}')" wire:confirm="Hapus file backup ini?" class="text-red-600 hover:text-red-800 text-xs underline">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Upload & Restore</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Upload file backup (.sql, .zip, .gz) untuk mengembalikan database.</p>
            </div>
            <div class="fi-section-content p-6 pt-0">
                <form wire:submit="restore" class="flex gap-3 items-end">
                    <div class="flex-1">
                        <input type="file" wire:model="restoreFile" accept=".sql,.zip,.gz" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border text-sm">
                        <div wire:loading wire:target="restoreFile" class="text-xs text-primary-600 mt-1">Uploading...</div>
                    </div>
                    <button type="submit" wire:loading.attr="disabled" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-5 py-2.5 text-sm shadow-sm bg-orange-600 text-white hover:bg-orange-500">
                        <span wire:loading.remove>Upload & Restore</span>
                        <span wire:loading>Restoring...</span>
                    </button>
                </form>
                <p class="text-xs text-amber-600 dark:text-amber-400 mt-3">Peringatan: Restore akan menimpa seluruh data yang ada saat ini. Pastikan Anda telah backup data terbaru.</p>
            </div>
        </div>
    </div>
</x-filament-panels::page>
