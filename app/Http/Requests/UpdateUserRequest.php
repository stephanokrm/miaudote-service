<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignoreModel(auth()->user())],
            'phone' => ['required', Rule::phone()->country(['BR'])->type('mobile')],
            'born_at' => ['required', 'date', "before_or_equal:{$before}", "after_or_equal:{$after}"],
            'ibge_city_id' => ['required', 'integer'],
        ];
    }
}
