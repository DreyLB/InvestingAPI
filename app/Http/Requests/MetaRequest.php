<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'nome'        => 'required|string|max:100',
      'descricao'   => 'nullable|string',
      'valor'       => 'required|numeric|min:0',
      'data_limite' => 'nullable|date|after:today',
    ];
  }
}
