<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // filtros
    public string $search = '';
    public ?string $filterPublished = null;
    public string $viewMode = 'grid'; // 'grid' ou 'list'

    protected $queryString = [
        'search'          => ['except' => ''],
        'filterPublished' => ['except' => null],
        'page'            => ['except' => 1],
    ];

    protected $listeners = [
        'articleSaved' => '$refresh',
        'articleDeleted' => '$refresh',
    ];

    // reset paginação ao mudar filtros
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPublished()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Article::query();

        // Admin vê todos os artigos, developers apenas seus próprios
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $query->withCount('developers');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        if ($this->filterPublished === 'published') {
            $query->whereNotNull('published_at');
        } elseif ($this->filterPublished === 'draft') {
            $query->whereNull('published_at');
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('livewire.articles.index', compact('articles'));
    }
}
