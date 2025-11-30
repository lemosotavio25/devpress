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

    // campos de endereço
    public string $cep = '';
    public string $logradouro = '';
    public string $complemento = '';
    public string $bairro = '';
    public string $localidade = '';
    public string $estado = '';
    public string $regiao = '';
    public bool $loadingCep = false;

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
            'cep' => 'nullable|string|max:9',
            'logradouro' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:100',
            'localidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'regiao' => 'nullable|string|max:100',
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
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'seniority', 'skills', 'newSkill', 'cep', 'logradouro', 'complemento', 'bairro', 'localidade', 'estado', 'regiao']);

        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->isEditing = true;
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->role = $this->user->role ?? 'developer';
            $this->seniority = $this->user->seniority;
            $this->skills = $this->user->skills ?? [];
            
            // carregar endereço se existir
            $address = $this->user->addresses()->first();
            if ($address) {
                $this->cep = $address->cep;
                $this->logradouro = $address->logradouro;
                $this->complemento = $address->complemento ?? '';
                $this->bairro = $address->bairro;
                $this->localidade = $address->localidade;
                $this->estado = $address->estado;
                $this->regiao = $address->regiao;
            }
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
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role', 'seniority', 'skills', 'newSkill', 'cep', 'logradouro', 'complemento', 'bairro', 'localidade', 'estado', 'regiao']);
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

    public function searchCep()
    {
        $cep = preg_replace('/[^0-9]/', '', $this->cep);
        
        if (strlen($cep) !== 8) {
            $this->addError('cep', 'CEP deve ter 8 dígitos');
            return;
        }

        $this->loadingCep = true;
        $this->resetErrorBag(['cep', 'logradouro', 'bairro', 'localidade', 'estado', 'regiao']);

        try {
            $response = \Illuminate\Support\Facades\Http::withOptions([
                'verify' => false, // desabilita verificação SSL em desenvolvimento
            ])->timeout(15)->get("http://viacep.com.br/ws/{$cep}/json/");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['erro']) && $data['erro'] === true) {
                    $this->addError('cep', 'CEP não encontrado');
                } else {
                    $this->cep = $data['cep'] ?? '';
                    $this->logradouro = $data['logradouro'] ?? '';
                    $this->bairro = $data['bairro'] ?? '';
                    $this->localidade = $data['localidade'] ?? '';
                    $this->estado = $data['uf'] ?? '';
                    
                    // Determinar a região baseada no estado
                    $regioes = [
                        'AC' => 'Norte', 'AP' => 'Norte', 'AM' => 'Norte', 'PA' => 'Norte', 'RO' => 'Norte', 'RR' => 'Norte', 'TO' => 'Norte',
                        'AL' => 'Nordeste', 'BA' => 'Nordeste', 'CE' => 'Nordeste', 'MA' => 'Nordeste', 'PB' => 'Nordeste', 'PE' => 'Nordeste', 'PI' => 'Nordeste', 'RN' => 'Nordeste', 'SE' => 'Nordeste',
                        'DF' => 'Centro-Oeste', 'GO' => 'Centro-Oeste', 'MT' => 'Centro-Oeste', 'MS' => 'Centro-Oeste',
                        'ES' => 'Sudeste', 'MG' => 'Sudeste', 'RJ' => 'Sudeste', 'SP' => 'Sudeste',
                        'PR' => 'Sul', 'RS' => 'Sul', 'SC' => 'Sul',
                    ];
                    
                    $this->regiao = $regioes[$this->estado] ?? '';
                }
            } else {
                $this->addError('cep', 'Erro ao buscar CEP. Tente novamente.');
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $this->addError('cep', 'Erro de conexão. Verifique sua internet.');
        } catch (\Exception $e) {
            $this->addError('cep', 'Erro ao buscar CEP: ' . $e->getMessage());
        } finally {
            $this->loadingCep = false;
        }
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
            $this->user = User::create($data);
        }

        // salvar endereço se CEP foi preenchido
        if ($this->cep) {
            $addressData = [
                'cep' => $this->cep,
                'logradouro' => $this->logradouro,
                'complemento' => $this->complemento,
                'bairro' => $this->bairro,
                'localidade' => $this->localidade,
                'estado' => $this->estado,
                'regiao' => $this->regiao,
            ];

            if ($this->isEditing) {
                // atualizar ou criar endereço
                $this->user->addresses()->updateOrCreate(
                    ['user_id' => $this->user->id],
                    $addressData
                );
            } else {
                $this->user->addresses()->create($addressData);
            }
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
