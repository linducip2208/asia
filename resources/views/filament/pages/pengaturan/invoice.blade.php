<x-filament-panels::page>
    <form wire:submit="save">
        <div class="space-y-6">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Format Nomor Invoice</h3>
                    <p class="text-sm text-gray-500">Konfigurasi penomoran invoice otomatis.</p>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Prefix</label>
                        <input type="text" wire:model="prefix" maxlength="10" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                        <p class="text-xs text-gray-500 mt-1">Kode di depan nomor (INV, PO, SO, dll).</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Separator</label>
                        <input type="text" wire:model="separator" maxlength="5" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Format Tanggal</label>
                        <select wire:model="date_format" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                            <option value="Ymd">Ymd (20260709)</option>
                            <option value="Ym">Ym (202607)</option>
                            <option value="Y">Y (2026)</option>
                            <option value="dmy">dmy (09072026)</option>
                            <option value="my">my (072026)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Panjang Nomor Urut</label>
                        <input type="number" wire:model="number_length" min="1" max="10" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                        <p class="text-xs text-gray-500 mt-1">Jumlah digit (4 = 0001, 5 = 00001).</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Berikutnya</label>
                        <input type="number" wire:model="next_number" min="1" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                </div>
            </div>

            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Preview</h3>
                </div>
                <div class="fi-section-content p-6 pt-0">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 text-center">
                        <span class="text-3xl font-bold font-mono text-gray-900 dark:text-white tracking-wider">{{ $this->preview }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">Contoh nomor invoice yang akan digenerate.</p>
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
</x-filament-panels::page>
