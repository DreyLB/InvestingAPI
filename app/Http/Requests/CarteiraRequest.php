<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarteiraRequest extends FormRequest
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
                'nome' => 'required|string|max:255',
                'descricao' => 'nullable|string',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Regras para atualização (update)
            return [
                'nome' => 'sometimes|required|string|max:255',
                'descricao' => 'nullable|string',
            ];
        }

        // Pode incluir regras padrão para outras chamadas, se quiser
        return [];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da carteira é obrigatório.',
            'nome.string' => 'O nome deve ser um texto válido.',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres.',
            'descricao.string' => 'A descrição deve ser um texto válido.',
        ];
    }
}
