<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            // intended name of the Group
            'name' => ['required', 'string', 'max:50'],
            // Array of group members user ids
            'member_ids' => ['required', 'array', 'min:2', 'max:5'],
            'member_ids.*' => ['integer', 'exists:users,id'],
        ];
    }
}
