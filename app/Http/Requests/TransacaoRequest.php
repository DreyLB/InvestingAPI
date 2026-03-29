<?php
// app/Http/Requests/TransacaoRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransacaoRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'tipo'       => 'required|in:compra,venda',
      'quantidade' => 'required|numeric|min:0',
      'valor'      => 'required|numeric|min:0',
      'data'       => 'required|date',
    ];
  }
}
