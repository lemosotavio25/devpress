<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateAddressForm extends Component
{
    public string $cep = '';
    public string $logradouro = '';
    public string $complemento = '';
    public string $bairro = '';
    public string $localidade = '';
    public string $estado = '';
    public string $regiao = '';
    public bool $loadingCep = false;

    public function mount()
    {
        $address = Auth::user()->addresses()->first();
        
        if ($address) {
            $this->cep = $address->cep;
            $this->logradouro = $address->logradouro;
            $this->complemento = $address->complemento ?? '';
            $this->bairro = $address->bairro;
            $this->localidade = $address->localidade;
            $this->estado = $address->estado;
            $this->regiao = $address->regiao;
        }
    }

    protected function rules()
    {
        return [
            'cep' => 'nullable|string|max:9',
            'logradouro' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:100',
            'localidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'regiao' => 'nullable|string|max:100',
        ];
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
            $response = \Illuminate\Support\Facades\Http::timeout(15)
                ->withOptions(['verify' => false])
                ->get("http://viacep.com.br/ws/{$cep}/json/");
            
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

    public function updateAddress()
    {
        $this->validate();

        $user = Auth::user();

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

            $user->addresses()->updateOrCreate(
                ['user_id' => $user->id],
                $addressData
            );

            session()->flash('address-updated', 'Endereço atualizado com sucesso!');
        } else {
            // Se não tem CEP, remove o endereço
            $user->addresses()->delete();
            session()->flash('address-updated', 'Endereço removido com sucesso!');
        }

        $this->dispatch('address-updated');
    }

    public function render()
    {
        return view('livewire.profile.update-address-form');
    }
}
