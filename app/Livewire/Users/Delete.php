<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Delete extends Component
{
    public ?User $user = null;
    public bool $showModal = false;

    protected $listeners = [
        'openDeleteUserModal' => 'openModal',
    ];

    public function openModal(int $userId)
    {
        $this->user = User::withCount(['articles', 'contributedArticles'])
            ->findOrFail($userId);
        
        // Impede que o usuário delete a si mesmo
        if ($this->user->id === Auth::id()) {
            session()->flash('error', 'Você não pode excluir sua própria conta!');
            return;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->user = null;
    }

    public function delete()
    {
        if (!$this->user) {
            return;
        }

        // Impede que o usuário delete a si mesmo
        if ($this->user->id === Auth::id()) {
            session()->flash('error', 'Você não pode excluir sua própria conta!');
            $this->closeModal();
            return;
        }

        // Remove o usuário
        $this->user->delete();

        $this->dispatch('userUpdated');
        $this->closeModal();

        session()->flash('message', 'Usuário excluído!');
    }

    public function render()
    {
        return view('livewire.users.delete');
    }
}
