<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use UnitEnum;

class PengaturanBackup extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static string|UnitEnum|null $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationLabel = 'Backup & Restore';
    protected static ?int $navigationSort = 20;
    protected string $view = 'filament.pages.pengaturan.backup';

    public $backups = [];
    public $backupProgress = false;
    public $restoreFile = null;

    public function mount(): void
    {
        $this->refreshBackups();
    }

    public function refreshBackups(): void
    {
        $path = storage_path('app/backups');
        if (!File::exists($path)) {
            $this->backups = [];
            return;
        }

        $files = File::files($path);
        $this->backups = collect($files)
            ->filter(fn ($f) => in_array($f->getExtension(), ['sql', 'zip', 'gz']))
            ->map(fn ($f) => [
                'name' => $f->getFilename(),
                'size' => $this->formatBytes($f->getSize()),
                'date' => date('d M Y H:i:s', $f->getMTime()),
                'path' => $f->getPathname(),
            ])
            ->sortByDesc('date')
            ->values()
            ->toArray();
    }

    public function createBackup(): void
    {
        $this->backupProgress = true;

        try {
            $filename = 'backup-' . now()->format('Ymd_His') . '.sql';
            $path = storage_path("app/backups/{$filename}");

            if (!File::exists(storage_path('app/backups'))) {
                File::makeDirectory(storage_path('app/backups'), 0755, true);
            }

            $db = config('database.connections.mysql');
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
                escapeshellarg($db['username']),
                escapeshellarg($db['password']),
                escapeshellarg($db['host']),
                escapeshellarg($db['port']),
                escapeshellarg($db['database']),
                escapeshellarg($path)
            );

            exec($command, $output, $exitCode);

            if ($exitCode === 0) {
                Notification::make()
                    ->title('Backup berhasil dibuat!')
                    ->body("File: {$filename}")
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Backup gagal!')
                    ->body('Pastikan mysqldump tersedia di PATH.')
                    ->danger()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Backup gagal!')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }

        $this->backupProgress = false;
        $this->refreshBackups();
    }

    public function downloadBackup($name): void
    {
        $path = storage_path("app/backups/{$name}");
        if (File::exists($path)) {
            response()->download($path)->send();
            exit;
        }
    }

    public function deleteBackup($name): void
    {
        $path = storage_path("app/backups/{$name}");
        if (File::exists($path)) {
            File::delete($path);
        }
        $this->refreshBackups();

        Notification::make()
            ->title('Backup dihapus!')
            ->success()
            ->send();
    }

    public function restore(): void
    {
        $this->validate(['restoreFile' => 'required|file|mimes:sql,zip,gz|max:51200']);

        try {
            $path = $this->restoreFile->storeAs('backups', 'restore-' . now()->format('Ymd_His') . '.sql');

            $fullPath = storage_path("app/{$path}");
            $db = config('database.connections.mysql');
            $command = sprintf(
                'mysql --user=%s --password=%s --host=%s --port=%s %s < %s',
                escapeshellarg($db['username']),
                escapeshellarg($db['password']),
                escapeshellarg($db['host']),
                escapeshellarg($db['port']),
                escapeshellarg($db['database']),
                escapeshellarg($fullPath)
            );

            exec($command, $output, $exitCode);

            if ($exitCode === 0) {
                Notification::make()
                    ->title('Restore berhasil!')
                    ->body('Database telah dikembalikan.')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Restore gagal!')
                    ->body('Pastikan mysql tersedia di PATH.')
                    ->danger()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Restore gagal!')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }

        $this->restoreFile = null;
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 1) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }
}
