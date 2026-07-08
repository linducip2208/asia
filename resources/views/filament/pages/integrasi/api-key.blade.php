<x-filament-panels::page>
    <div class="space-y-6">
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Generate API Key Baru</h3>
            </div>
            <div class="fi-section-content p-6 pt-0">
                <form wire:submit="generateToken" class="flex gap-3 items-end">
                    <div class="flex-1">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama Token</label>
                        <input type="text" wire:model="tokenName" maxlength="255" placeholder="Mobile App v1" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 py-2.5 border">
                    </div>
                    <button type="submit" wire:loading.attr="disabled" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-5 py-2.5 text-sm shadow-sm bg-primary-600 text-white hover:bg-primary-500">
                        <span wire:loading.remove>Generate</span>
                        <span wire:loading>...</span>
                    </button>
                </form>
            </div>
        </div>

        @if($generatedToken)
        <div class="rounded-xl bg-green-50 border border-green-300 p-4 dark:bg-green-900/20 dark:border-green-800">
            <p class="text-sm font-semibold text-green-800 dark:text-green-300 mb-2">Token baru berhasil dibuat!</p>
            <div class="flex items-center gap-2">
                <code class="flex-1 bg-white dark:bg-gray-900 border rounded px-3 py-2 text-xs break-all font-mono">{{ $generatedToken }}</code>
                <button type="button" onclick="navigator.clipboard.writeText('{{ $generatedToken }}')" class="text-xs bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 whitespace-nowrap">Copy</button>
            </div>
            <p class="text-xs text-green-700 dark:text-green-400 mt-2">Salin token sekarang — token ini tidak akan ditampilkan lagi.</p>
        </div>
        @endif

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">API Keys Aktif</h3>
            </div>
            <div class="fi-section-content p-6 pt-0">
                @php
                    $tokens = auth()->user()->tokens;
                @endphp
                @if($tokens->isEmpty())
                    <p class="text-gray-500 text-sm">Belum ada API key.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Nama Token</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Terakhir Digunakan</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Dibuat</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokens as $token)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-3 py-3 font-mono text-xs">{{ $token->name }}</td>
                                <td class="px-3 py-3 text-xs text-gray-500">{{ $token->last_used_at ? $token->last_used_at->format('d M Y H:i:s') : 'Belum pernah' }}</td>
                                <td class="px-3 py-3 text-xs text-gray-500">{{ $token->created_at->format('d M Y H:i:s') }}</td>
                                <td class="px-3 py-3">
                                    <button type="button" wire:click="revokeToken({{ $token->id }})" wire:confirm="Revoke API key ini?" class="text-red-600 hover:text-red-800 text-xs underline">Revoke</button>
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
