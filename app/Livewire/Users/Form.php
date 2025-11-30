<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public ?User $user = null;
    public bool $isEditing = false;

    // campos
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?string $role = 'developer';
    public ?string $seniority = null;
    public array $skills = [];
    public string $newSkill = '';

    // para mostrar/esconder modal
    public bool $showModal = false;

    protected $listeners = [
        'openUserModal' => 'openModal',
    ];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user?->id),
            ],
            'role' => 'required|in:admin,developer',
            'seniority' => 'nullable|in:jr,pl,sr',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
        ];

        if (!$this->isEditing) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } elseif ($this->password) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function openModal(?int $userId = null)
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'seniority', 'skills', 'newSkill']);

        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->isEditing = true;
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->role = $this->user->role ?? 'developer';
            $this->seniority = $this->user->seniority;
            $this->skills = $this->user->skills ?? [];
        } else {
            $this->user = null;
            $this->isEditing = false;
            $this->role = 'developer';
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'seniority', 'skills', 'newSkill']);
        $this->resetValidation();
    }

    public function addSkill()
    {
        $skill = trim($this->newSkill);
        
        if ($skill && !in_array($skill, $this->skills)) {
            $this->skills[] = $skill;
            $this->newSkill = '';
        }
    }

    public function removeSkill($index)
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'seniority' => $this->seniority,
            'skills' => $this->skills,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEditing) {
            $this->user->update($data);
        } else {
            User::create($data);
        }

        $this->dispatch('userUpdated');
        $this->closeModal();

        session()->flash('message', $this->isEditing ? 'Usuário atualizado!' : 'Usuário criado!');
    }

    public function render()
    {
        return view('livewire.users.form');
    }
}
