<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRequest extends FormRequest
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
     public function register() : array {
        return [
            'name' => ['required', 'not_regex:/^.+@.+$/i'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ];
     }

     public function login() : array {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
     }

    // public function rules(): array
    // {
    //     return array_merge(
    //         $this->register(),
    //     );
    // }

}
