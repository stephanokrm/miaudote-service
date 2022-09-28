<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $before = Carbon::today()->subYears(18)->format('Y-m-d');
        $after = Carbon::today()->subYears(150)->format('Y-m-d');

        return [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed', Password::default()],
            'phone' => ['required', 'phone'],
            'born_at' => ['required', 'date', "before_or_equal:{$before}", "after_or_equal:{$after}"],
            'ibge_city_id' => ['required', 'integer'],
        ];
    }
}
