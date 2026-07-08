<?php

namespace App\Filament\Super\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class SystemMonitoring extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-server';
    protected static string|UnitEnum|null $navigationGroup = '📊 Monitoring';
    protected static ?string $navigationLabel = 'System Monitoring';
    protected static ?string $title = 'System Monitoring';
    protected static ?int $navigationSort = 20;
    protected string $view = 'filament.super.system-monitoring';

    public string $phpVersion = '';
    public string $laravelVersion = '';
    public string $dbSize = '';
    public string $diskUsage = '';
    public string $diskFree = '';
    public int $queueSize = 0;
    public int $failedJobs = 0;

    public function mount(): void
    {
        $this->phpVersion = PHP_VERSION;
        $this->laravelVersion = app()->version();

        try {
            $dbName = DB::connection()->getDatabaseName();
            $result = DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb FROM information_schema.tables WHERE table_schema = ?", [$dbName]);
            $this->dbSize = ($result[0]->size_mb ?? 0) . ' MB';
        } catch (\Throwable $e) {
            $this->dbSize = 'N/A';
        }

        try {
            $total = disk_total_space(base_path());
            $free = disk_free_space(base_path());
            $used = $total - $free;
            $this->diskUsage = $this->formatBytes($used) . ' / ' . $this->formatBytes($total);
            $this->diskFree = $this->formatBytes($free);
        } catch (\Throwable $e) {
            $this->diskUsage = 'N/A';
            $this->diskFree = 'N/A';
        }

        try {
            $this->queueSize = DB::table('jobs')->count();
        } catch (\Throwable $e) {
            $this->queueSize = 0;
        }

        try {
            $this->failedJobs = DB::table('failed_jobs')->count();
        } catch (\Throwable $e) {
            $this->failedJobs = 0;
        }
    }

    protected function formatBytes(float $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $pow = min($pow, count($units) - 1);
        $bytes /= (1024 ** $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
