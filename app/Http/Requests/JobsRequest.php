<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobsRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }
    public function messages(): array
    {
        return [
            'name' => 'Campo nome é obrigatório',
            'email.required' => 'Campo e-mail é obrigatorio',
            'email.email' => 'Campo deve ser um email valido!',
            'password.required' => 'Campo senha é obrigatorio',
            'password.min' => 'O campo de senha deve ter pelo menos 6 caracteres.'
        ];
    }
}
