<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_solicitante' => 'required|string|max:255',
            'email_solicitante' => 'required|email',
            'destino' => 'required|string|max:255',
            'data_ida' => 'required|date|after_or_equal:today',
            'data_volta' => 'required|date|after:data_ida',
            'status' => 'nullable|in:solicitado',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome_solicitante.required' => 'O nome do solicitante é obrigatório.',
            'nome_solicitante.string' => 'O nome do solicitante deve ser uma string.',
            'nome_solicitante.max' => 'O nome do solicitante não pode ter mais de 255 caracteres.',
            'email_solicitante.required' => 'O email do solicitante é obrigatório.',
            'email_solicitante.email' => 'O email do solicitante deve ser um endereço de email válido.',
            'destino.required' => 'O destino é obrigatório.',
            'destino.string' => 'O destino deve ser uma string.',
            'destino.max' => 'O destino não pode ter mais de 255 caracteres.',
            'data_ida.required' => 'A data de ida é obrigatória.',
            'data_ida.date' => 'A data de ida deve ser uma data válida.',
            'data_ida.after_or_equal' => 'A data de ida não pode ser anterior à data atual.',
            'data_volta.required' => 'A data de volta é obrigatória.',
            'data_volta.date' => 'A data de volta deve ser uma data válida.',
            'data_volta.after' => 'A data de volta deve ser posterior à data de ida.',
            'status.in' => 'O status deve ser solicitado',
        ];
    }
}
