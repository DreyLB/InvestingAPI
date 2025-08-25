<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetTypeRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true; // ou faça checagem de permissão aqui, se quiser
  }

  public function rules(): array
  {
    if ($this->isMethod('post')) {
      // Regras para criação (store)
      return [
        'carteira_id'   => 'required|exists:carteiras,id',
        'categoria_id'  => 'nullable|exists:asset_types,id',
        'nome'          => 'required|string|max:255',
        'tipo'          => 'nullable|string|max:50',
        'quantidade'    => 'required|integer|min:1',
        'preco'         => 'required|numeric|min:0',
        'preco_medio'   => 'required|numeric|min:0',
      ];
    }

    if ($this->isMethod('put') || $this->isMethod('patch')) {
      // Regras para atualização (update)
      return [
        'categoria_id' => 'nullable|exists:asset_types,id',
        'nome'        => 'sometimes|string|max:255',
        'tipo'        => 'nullable|string|max:50',
        'quantidade'  => 'sometimes|integer|min:1',
        'preco'       => 'sometimes|numeric|min:0',
        'preco_medio' => 'sometimes|numeric|min:0',
      ];
    }

    // Pode incluir regras padrão para outras chamadas, se quiser
    return [];
  }
}
