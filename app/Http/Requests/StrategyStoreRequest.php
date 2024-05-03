<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StrategyStoreRequest extends FormRequest
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
            'dsEstrategia' => 'required|string',
            'nrPrioridade' => 'required|integer',
            'horarios' => 'required|array',
            'horarios.*.dsHorarioInicio' => 'required|string',
            'horarios.*.dsHorarioFinal' => 'required|string',
            'horarios.*.nrPrioridade' => 'required|integer',
        ];
    }
}
