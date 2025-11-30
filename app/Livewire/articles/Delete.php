<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Delete extends Component
{
    public ?Article $article = null;
    public bool $showModal = false;

    protected $listeners = [
        'openDeleteArticleModal' => 'openModal',
    ];

    public function openModal(int $articleId)
    {
        $query = Article::query();

        // Admin pode deletar tudo, developers apenas seus próprios
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $this->article = $query->findOrFail($articleId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->article = null;
    }

    public function delete()
    {
        if (!$this->article) {
            return;
        }

        // remove imagem de capa se existir
        if ($this->article->cover_image_path) {
            Storage::disk('public')->delete($this->article->cover_image_path);
        }

        $this->article->delete();

        $this->dispatch('articleDeleted');
        $this->closeModal();

        session()->flash('message', 'Artigo excluído!');
    }

    public function render()
    {
        return view('livewire.articles.delete');
    }
}
