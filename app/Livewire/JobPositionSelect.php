<?php

namespace App\Livewire;

use App\Models\JobPosition;
use Livewire\Component;
use App\Models\Job_position;
use Livewire\WithPagination;

class JobPositionSelect extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $selectedId = null;
    public string $selectedLabel = '';
    public bool $isOpen = false; // kontrolira vidljivost liste (Alpine + entangle)
    public int $perPage = 100;

    protected $queryString = ['search']; // opcionalno: zadrži search u URL-u

    public function mount(?int $selectedId = null): void
    {
        if ($selectedId) {
            $this->selectedId = $selectedId;
            $this->selectedLabel = JobPosition::find($selectedId)?->name ?? '';
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->isOpen = true;
    }

    public function select(int $id): void
    {
        $jp = JobPosition::find($id);
        if ($jp) {
            $this->selectedId = $jp->id;
            $this->selectedLabel = $jp->name;
            $this->isOpen = false;
            // po želji emitiraj event:
            // $this->dispatch('job-position-selected', id: $jp->id, label: $jp->name);
        }
    }

    public function clear(): void
    {
        $this->selectedId = null;
        $this->selectedLabel = '';
        $this->search = '';
        $this->resetPage();
        $this->isOpen = false;
    }

    public function getResultsProperty()
    {
        return JobPosition::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
            )
            ->orderBy('name')
            ->paginate($this->perPage);
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function render()
    {
        return view('livewire.job-position-select', [
            'results' => $this->results, // accessor iz getResultsProperty()
        ]);
    }
}