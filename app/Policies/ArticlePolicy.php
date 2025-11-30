<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos podem ver a lista de artigos
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        // Admin vê tudo, usuários veem apenas seus próprios artigos
        return $user->isAdmin() || $article->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Todos usuários autenticados podem criar artigos
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        // Admin pode editar tudo, usuários apenas seus próprios
        return $user->isAdmin() || $article->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        // Admin pode deletar tudo, usuários apenas seus próprios
        return $user->isAdmin() || $article->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return $user->isAdmin();
    }
}
