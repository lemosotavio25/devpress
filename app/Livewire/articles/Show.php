<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Article $article;

    public function mount($slug)
    {
        $query = Article::where('slug', $slug)->with('developers');

        // Admin vê tudo, developers apenas seus próprios
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $this->article = $query->firstOrFail();
    }

    public function render()
    {
        return view('livewire.articles.show');
    }
}
