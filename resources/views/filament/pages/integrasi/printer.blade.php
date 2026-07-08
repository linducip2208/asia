<x-filament-panels::page>
    <div class="space-y-6">
        <form wire:submit="save" class="space-y-6">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-header px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">{{ $editId ? 'Edit Printer' : 'Tambah Printer' }}</h3>
                </div>
                <div class="fi-section-content p-6 pt-0 grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Printer</label>
                        <input type="text" wire:model="editingName" maxlength="100" placeholder="Printer Kasir 1" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tipe</label>
                        <select wire:model="editingType" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                            <option value="bluetooth">Bluetooth</option>
                            <option value="usb">USB</option>
                            <option value="network">Network / LAN</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Alamat / Address</label>
                        <input type="text" wire:model="editingAddress" maxlength="255" placeholder="00:11:22:33:44:55 atau 192.168.1.100:9100" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                        <p class="text-xs text-gray-500 mt-1">MAC address untuk Bluetooth, IP:port untuk Network, atau port name untuk USB.</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran Kertas</label>
                        <select wire:model="editingPaperSize" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                            <option value="58mm">58mm (Thermal Kecil)</option>
                            <option value="80mm">80mm (Thermal Standar)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Karakter per Baris</label>
                        <input type="number" wire:model="editingCharsPerLine" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <div class="flex items-end gap-6">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <input type="checkbox" wire:model="editingIsActive" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            Aktif
                        </label>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <input type="checkbox" wire:model="editingIsDefault" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            Default
                        </label>
                    </div>
                </div>
                <div class="px-6 pb-4 flex gap-2">
                    <button type="submit" wire:loading.attr="disabled" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-5 py-2.5 text-sm shadow-sm bg-primary-600 text-white hover:bg-primary-500">
                        <span wire:loading.remove>{{ $editId ? 'Update' : 'Simpan' }}</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                    @if($editId)
                    <button type="button" wire:click="resetForm" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-5 py-2.5 text-sm shadow-sm bg-gray-500 text-white hover:bg-gray-400">Batal</button>
                    @endif
                </div>
            </div>
        </form>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Daftar Printer</h3>
            </div>
            <div class="fi-section-content p-6 pt-0">
                @if(empty($printers))
                    <p class="text-gray-500 text-sm">Belum ada printer terdaftar.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Nama</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Tipe</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Kertas</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Status</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($printers as $printer)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-3 py-3">
                                    {{ $printer['name'] }}
                                    @if($printer['is_default'])
                                        <span class="ml-1 text-xs bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full font-medium">Default</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 uppercase text-xs">{{ $printer['api_format'] }}</td>
                                <td class="px-3 py-3">{{ $printer['extra_config']['paper_size'] ?? '-' }}</td>
                                <td class="px-3 py-3">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $printer['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $printer['is_active'] ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex gap-1">
                                        <button type="button" wire:click="edit({{ $printer['id'] }})" class="text-primary-600 hover:text-primary-800 text-xs underline">Edit</button>
                                        @if(!$printer['is_default'])
                                        <button type="button" wire:click="setDefault({{ $printer['id'] }})" class="text-gray-600 hover:text-gray-800 text-xs underline">Default</button>
                                        @endif
                                        <button type="button" wire:click="delete({{ $printer['id'] }})" wire:confirm="Hapus printer ini?" class="text-red-600 hover:text-red-800 text-xs underline">Hapus</button>
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
    </div>
</x-filament-panels::page>
