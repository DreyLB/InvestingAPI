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
        'nome'      => 'required|string|max:255',
        'descricao' => 'nullable|string|max:500',
      ];
    }

    if ($this->isMethod('put') || $this->isMethod('patch')) {
      // Regras para atualização (update)
      return [
        'nome'      => 'required|string|max:255',
        'descricao' => 'nullable|string|max:500',
      ];
    }

    // Pode incluir regras padrão para outras chamadas, se quiser
    return [];
  }
}
