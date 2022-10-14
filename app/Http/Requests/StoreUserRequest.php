<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
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
     * @return array
     */
    public function rules(): array
    {
        $before = Carbon::today()->subYears(18)->format('Y-m-d');
        $after = Carbon::today()->subYears(150)->format('Y-m-d');

        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'confirmed', Password::default()],
            'phone' => ['required', Rule::phone()->country(['BR'])->type('mobile')],
            'born_at' => ['required', 'date', "before_or_equal:{$before}", "after_or_equal:{$after}"],
            'ibge_city_id' => ['required', 'integer'],
            'file' => ['required', File::image()->max(5000)],
        ];
    }
}
