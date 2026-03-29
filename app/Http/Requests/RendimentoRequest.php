<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RendimentoRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'rendimento'  => 'required|in:mensal,trimestral,anual',
      'valor'       => 'required|numeric|min:0',
      'periodo_ini' => 'required|date',
      'periodo_fim' => 'required|date|after_or_equal:periodo_ini',
    ];
  }
}
