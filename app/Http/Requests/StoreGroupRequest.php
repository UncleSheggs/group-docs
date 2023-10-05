<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

final class StoreGroupRequest extends FormRequest
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
            // Group admin user id
            'admin_id' => ['required', 'numeric', 'exists:users,id'],
            // Id of the type of service the group offers (rent | subscription)
            'service_id' => ['required', 'numeric', 'exists:services,id'],
            // Intended name for the Group
            'name' => ['required', 'string', 'max:50'],
            // Payment interval members of the group
            'interval' => ['required', new Enum(\App\Enums\PaymentInterval::class)],
            // Maximum members allowed
            'limit' => ['required', 'numeric', 'min:2'],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
