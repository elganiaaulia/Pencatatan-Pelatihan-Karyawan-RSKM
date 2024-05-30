<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'full_name' => 'required',
            'NIK' => 'required|numeric|unique:users,NIK',
            'unit' => 'string',
            'role' => 'required'
        ];
    }

    public function messages()
    {
        return[
            'full_name.required' => 'Nama lengkap harus diisi',
            'NIK.required' => 'NIK wajib diisi',
            'NIK.numeric' => 'NIK harus berupa angka',
            'NIK.unique' => 'NIK sudah terdaftar',
            'unit.string' => 'Unit harus berupa huruf',
            'role.required' => 'Role wajib diisi'
        ];
    }
}
