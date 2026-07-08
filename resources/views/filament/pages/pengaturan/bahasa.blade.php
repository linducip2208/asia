<x-filament-panels::page>
    <form wire:submit="save">
        <div class="space-y-6">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Pengaturan Bahasa</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pilih bahasa default aplikasi.</p>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Bahasa</label>
                        <select wire:model="locale" class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5">
                            @foreach ($locales as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <x-filament::button type="submit">Simpan</x-filament::button>
            </div>
        </div>
    </form>
</x-filament-panels::page>
