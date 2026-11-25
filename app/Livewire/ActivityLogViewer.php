<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogViewer extends Component
{
    use WithPagination;

    public string $search = '';
    public string $moduleFilter = '';
    public string $actionFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingModuleFilter(): void
    {
        $this->resetPage();
    }

    public function updatingActionFilter(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'moduleFilter', 'actionFilter']);
        $this->resetPage();
    }

    public function getHasActiveFiltersProperty(): bool
    {
        return !empty($this->search) || !empty($this->moduleFilter) || !empty($this->actionFilter);
    }

    public function render()
    {
        $logs = ActivityLog::with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                      ->orWhere('user_name', 'like', '%' . $this->search . '%')
                      ->orWhere('ip_address', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->moduleFilter, function ($query) {
                $query->where('module', $this->moduleFilter);
            })
            ->when($this->actionFilter, function ($query) {
                $query->where('action', $this->actionFilter);
            })
            ->latest('id')
            ->paginate(15);

        $modules = ActivityLog::distinct()->pluck('module');
        $actions = ActivityLog::distinct()->pluck('action');

        return view('livewire.activity-log-viewer', [
            'logs' => $logs,
            'modules' => $modules,
            'actions' => $actions,
        ]);
    }
}
