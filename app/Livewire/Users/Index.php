<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // filtros
    public string $search = '';
    public ?string $filterRole = null;
    public ?string $filterSeniority = null;

    protected $queryString = [
        'search'          => ['except' => ''],
        'filterRole'      => ['except' => null],
        'filterSeniority' => ['except' => null],
        'page'            => ['except' => 1],
    ];

    protected $listeners = [
        'userUpdated' => '$refresh',
    ];

    // reset paginação ao mudar filtros
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function updatingFilterSeniority()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();

        $query->withCount(['articles', 'contributedArticles']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        if ($this->filterRole) {
            $query->where('role', $this->filterRole);
        }

        if ($this->filterSeniority) {
            $query->where('seniority', $this->filterSeniority);
        }

        $users = $query->orderBy('name')->paginate(12);

        return view('livewire.users.index', compact('users'));
    }
}
