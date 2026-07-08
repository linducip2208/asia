<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-primary-100 p-3 text-primary-600 dark:bg-primary-500/10"><x-heroicon-o-code-bracket class="h-6 w-6" /></span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">PHP Version</p>
                        <p class="text-xl font-bold text-gray-950 dark:text-white">{{ $phpVersion }}</p>
                    </div>
                </div>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-danger-100 p-3 text-danger-600 dark:bg-danger-500/10"><x-heroicon-o-fire class="h-6 w-6" /></span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Laravel Version</p>
                        <p class="text-xl font-bold text-gray-950 dark:text-white">{{ $laravelVersion }}</p>
                    </div>
                </div>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-info-100 p-3 text-info-600 dark:bg-info-500/10"><x-heroicon-o-circle-stack class="h-6 w-6" /></span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ukuran Database</p>
                        <p class="text-xl font-bold text-gray-950 dark:text-white">{{ $dbSize }}</p>
                    </div>
                </div>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-warning-100 p-3 text-warning-600 dark:bg-warning-500/10"><x-heroicon-o-server-stack class="h-6 w-6" /></span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Penggunaan Disk</p>
                        <p class="text-xl font-bold text-gray-950 dark:text-white">{{ $diskUsage }}</p>
                        <p class="text-xs text-gray-400">Sisa: {{ $diskFree }}</p>
                    </div>
                </div>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-success-100 p-3 text-success-600 dark:bg-success-500/10"><x-heroicon-o-queue-list class="h-6 w-6" /></span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Antrian Job</p>
                        <p class="text-xl font-bold text-gray-950 dark:text-white">{{ $queueSize }}</p>
                    </div>
                </div>
            </div>
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center rounded-lg bg-danger-100 p-3 text-danger-600 dark:bg-danger-500/10"><x-heroicon-o-exclamation-triangle class="h-6 w-6" /></span>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Failed Jobs</p>
                        <p class="text-xl font-bold text-gray-950 dark:text-white">{{ $failedJobs }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
