<x-filament-panels::page>
    <div class="space-y-6">
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Filter</h3>
            </div>
            <div class="fi-section-content p-6 pt-0">
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="w-48">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                        <select wire:model.live="filter_user" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-2 text-sm border">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-44">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Action</label>
                        <select wire:model.live="filter_action" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-2 text-sm border">
                            <option value="">Semua Action</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}">{{ $action }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-40">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                        <input type="date" wire:model="filter_date_from" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-2 text-sm border">
                    </div>
                    <div class="w-40">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                        <input type="date" wire:model="filter_date_to" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-2 text-sm border">
                    </div>
                    <div class="flex gap-2">
                        <button type="button" wire:click="applyDateFilter" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-4 py-2 text-sm shadow-sm bg-primary-600 text-white hover:bg-primary-500">Filter</button>
                        <button type="button" wire:click="clearFilters" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg px-4 py-2 text-sm shadow-sm bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Clear</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header px-6 py-4">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">Activity Log</h3>
                <p class="text-sm text-gray-500">Menampilkan maksimal 200 log terbaru.</p>
            </div>
            <div class="fi-section-content p-6 pt-0">
                @if(empty($logs))
                    <p class="text-gray-500 text-sm text-center py-8">Tidak ada aktivitas.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400 w-32">Tanggal</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">User</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Action</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Model</th>
                                <th class="px-3 py-3 font-semibold text-gray-600 dark:text-gray-400">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-3 py-3 text-xs text-gray-500 whitespace-nowrap">{{ $log['created_at'] }}</td>
                                <td class="px-3 py-3">
                                    <span class="text-xs font-medium">{{ $log['user_name'] }}</span>
                                    @if($log['ip_address'])
                                        <span class="block text-xs text-gray-400">{{ $log['ip_address'] }}</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                        {{ $log['action'] === 'created' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $log['action'] === 'updated' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $log['action'] === 'deleted' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ !in_array($log['action'], ['created','updated','deleted']) ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ $log['action'] }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-xs">
                                    {{ $log['model_type'] }}
                                    @if($log['model_id'])
                                        <span class="text-gray-400">#{{ $log['model_id'] }}</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-xs text-gray-500 max-w-xs">
                                    @if(!empty($log['new_values']))
                                        @php $changes = []; @endphp
                                        @foreach($log['new_values'] as $key => $val)
                                            @php $old = $log['old_values'][$key] ?? '-'; @endphp
                                            @if($old !== $val)
                                                @php $changes[] = "<span class='font-mono text-gray-600 dark:text-gray-400'>{$key}</span>: <span class='text-red-500 line-through'>".(is_array($old)?json_encode($old):$old)."</span> &rarr; <span class='text-green-500'>".(is_array($val)?json_encode($val):$val)."</span>"; @endphp
                                            @endif
                                        @endforeach
                                        @if(!empty($changes))
                                            {!! implode('<br>', $changes) !!}
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-gray-400 mt-3">Menampilkan {{ count($logs) }} dari maksimal 200 log terbaru.</p>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
