<?php
// app/Http/Requests/TransacaoVendaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransacaoVendaRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'asset_id'      => 'required|exists:assets,id',
      'quantidade'    => 'required|numeric|min:0.00000001',
      'preco_unitario' => 'required|numeric|min:0',
      'data'          => 'required|date',
    ];
  }
}
