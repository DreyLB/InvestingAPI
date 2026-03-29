<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransacaoCompraRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'nome'          => 'required|string|max:255',
      'asset_type_id' => 'required|exists:asset_types,id',
      'category_id'   => 'nullable|exists:categories,id',
      'quantidade'    => 'required|numeric|min:0.00000001',
      'valor'         => 'required|numeric|min:0',
      'data'          => 'required|date',
    ];
  }
}
