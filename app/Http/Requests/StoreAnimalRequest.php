<?php

namespace App\Http\Requests;

use App\Enums\Friendly;
use App\Enums\Gender;
use App\Enums\Playfulness;
use App\Enums\Species;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreAnimalRequest extends FormRequest
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
        $before = Carbon::today()->addDay()->format('Y-m-d');
        $after = Carbon::today()->subYears(30)->format('Y-m-d');

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'born_at' => ['required', 'date', "before_or_equal:{$before}", "after_or_equal:{$after}"],
            'gender' => ['required', new Enum(Gender::class)],
            'playfulness' => ['required', new Enum(Playfulness::class)],
            'family_friendly' => ['required', new Enum(Friendly::class)],
            'pet_friendly' => ['required', new Enum(Friendly::class)],
            'children_friendly' => ['required', new Enum(Friendly::class)],
            'species' => ['required', new Enum(Species::class)],
            'ibge_city_id' => ['required', 'integer'],
            'breed' => ['required_without:breed_id', 'string'],
            'breed_id' => ['required_without:breed', 'uuid', Rule::exists('breeds')],
            'image' => ['required', 'image'],
        ];
    }
}
