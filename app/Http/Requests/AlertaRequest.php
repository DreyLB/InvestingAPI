<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlertaRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'tipo'     => 'required|in:preco,meta,risco,dividendo',
      'mensagem' => 'required|string',
      'data'     => 'required|date',
    ];
  }
}
