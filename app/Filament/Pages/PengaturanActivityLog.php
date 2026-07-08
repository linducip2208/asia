<?php

namespace App\Filament\Pages;

use App\Models\AuditLog;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class PengaturanActivityLog extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static string|UnitEnum|null $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationLabel = 'Activity Log';
    protected static ?int $navigationSort = 30;
    protected string $view = 'filament.pages.pengaturan.activity-log';

    public $logs = [];
    public $filter_user = '';
    public $filter_action = '';
    public $filter_date_from = '';
    public $filter_date_to = '';
    public $users = [];
    public $actions = [];

    public function mount(): void
    {
        $this->users = DB::table('users')->select('id', 'name')->orderBy('name')->get()->toArray();
        $this->actions = AuditLog::select('action')->distinct()->orderBy('action')->pluck('action')->toArray();
        $this->loadLogs();
    }

    public function loadLogs(): void
    {
        $query = AuditLog::with('user')->latest();

        if ($this->filter_user) {
            $query->where('user_id', $this->filter_user);
        }

        if ($this->filter_action) {
            $query->where('action', $this->filter_action);
        }

        if ($this->filter_date_from) {
            $query->whereDate('created_at', '>=', $this->filter_date_from);
        }

        if ($this->filter_date_to) {
            $query->whereDate('created_at', '<=', $this->filter_date_to);
        }

        $this->logs = $query->limit(200)->get()->map(function ($log) {
            return [
                'id' => $log->id,
                'user_name' => $log->user?->name ?? 'System',
                'action' => $log->action,
                'model_type' => $log->model_type ? class_basename($log->model_type) : '-',
                'model_id' => $log->model_id,
                'old_values' => $log->old_values,
                'new_values' => $log->new_values,
                'ip_address' => $log->ip_address,
                'created_at' => $log->created_at->format('d M Y H:i:s'),
            ];
        })->toArray();
    }

    public function updatedFilterUser(): void
    {
        $this->loadLogs();
    }

    public function updatedFilterAction(): void
    {
        $this->loadLogs();
    }

    public function applyDateFilter(): void
    {
        $this->loadLogs();
    }

    public function clearFilters(): void
    {
        $this->filter_user = '';
        $this->filter_action = '';
        $this->filter_date_from = '';
        $this->filter_date_to = '';
        $this->loadLogs();
    }
}
