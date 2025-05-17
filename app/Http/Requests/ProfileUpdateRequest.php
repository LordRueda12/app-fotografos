<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['required', 'string', 'max:15'],
            'cedula' => ['nullable', 'string', 'max:20'],
            'precio_foto' => ['nullable', 'integer'],
            'certificado' => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image'], 
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
