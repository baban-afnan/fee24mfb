<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bvn'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone_no' => ['nullable', 'digits:11'],
            'bvn'      => ['nullable', 'digits:11'],
            'nin'      => ['nullable', 'digits:11'],
            'address'  => ['nullable', 'string', 'max:255'],
            'photo'  => ['nullable', 'string', 'max:255'],
            'profile_photo_url'  => ['nullable', 'string', 'max:255'],
        ];
    }
}
