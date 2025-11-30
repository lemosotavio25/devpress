<?php

namespace App\Livewire\Articles;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public ?Article $article = null;
    public bool $isEditing = false;

    // campos
    public string $title = '';
    public string $content = '';
    public ?string $published_at = null;
    public $cover_image;
    public array $selectedDevelopers = [];

    // para mostrar/esconder modal
    public bool $showModal = false;

    protected $listeners = [
        'openArticleModal' => 'openModal',
    ];

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
            'selectedDevelopers' => 'nullable|array',
            'selectedDevelopers.*' => 'exists:users,id',
        ];

        if ($this->cover_image && !is_string($this->cover_image)) {
            $rules['cover_image'] = 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240';
        }

        return $rules;
    }

    public function openModal(?int $articleId = null)
    {
        $this->resetValidation();
        $this->reset(['title', 'content', 'published_at', 'cover_image', 'selectedDevelopers']);

        if ($articleId) {
            $this->article = Article::where('user_id', Auth::id())->findOrFail($articleId);
            $this->isEditing = true;
            $this->title = $this->article->title;
            $this->content = $this->article->content ?? '';
            $this->published_at = $this->article->published_at?->format('Y-m-d');
            $this->selectedDevelopers = $this->article->developers->pluck('id')->toArray();
        } else {
            $this->article = null;
            $this->isEditing = false;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['title', 'content', 'published_at', 'cover_image', 'selectedDevelopers']);
        $this->resetValidation();
    }

    public function removeCoverImage()
    {
        if ($this->isEditing && $this->article->cover_image_path) {
            Storage::disk('public')->delete($this->article->cover_image_path);
            $this->article->update(['cover_image_path' => null]);
            $this->article->refresh();
        }
    }

    public function save()
    {
        $this->validate();

        // gera slug único
        $slug = Str::slug($this->title);
        $originalSlug = $slug;
        $counter = 1;

        // verifica se o slug já existe (exceto no próprio artigo ao editar)
        while (Article::where('slug', $slug)
            ->when($this->isEditing, fn($query) => $query->where('id', '!=', $this->article->id))
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data = [
            'title' => $this->title,
            'slug' => $slug,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'user_id' => Auth::id(),
        ];

        // upload de imagem
        if ($this->cover_image && !is_string($this->cover_image)) {
            // remove imagem antiga se existir
            if ($this->isEditing && $this->article->cover_image_path) {
                Storage::disk('public')->delete($this->article->cover_image_path);
            }

            $path = $this->cover_image->store('articles', 'public');
            $data['cover_image_path'] = $path;
        }

        if ($this->isEditing) {
            $this->article->update($data);
            $article = $this->article;
        } else {
            $article = Article::create($data);
        }

        // sincroniza developers
        $article->developers()->sync($this->selectedDevelopers);

        $this->dispatch('articleSaved');
        $this->closeModal();

        session()->flash('message', $this->isEditing ? 'Artigo atualizado!' : 'Artigo criado!');
    }

    public function render()
    {
        $developers = User::where('role', 'developer')
            ->orderBy('name')
            ->get();

        return view('livewire.articles.form', compact('developers'));
    }
}
