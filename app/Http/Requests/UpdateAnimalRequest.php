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
use Illuminate\Validation\Rules\File;

class UpdateAnimalRequest extends FormRequest
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
        $before = Carbon::today()->addDay()->format('Y-m-d');
        $after = Carbon::today()->subYears(30)->format('Y-m-d');

        return [
            'born_at' => ['required', 'date', "before_or_equal:{$before}", "after_or_equal:{$after}"],
            'breed_id' => ['nullable', 'required_without:breed_name', 'uuid', Rule::exists('breeds', 'id')],
            'breed_name' => ['nullable', 'required_without:breed_id', 'string'],
            'breed_species' => ['required', new Enum(Species::class)],
            'children_friendly' => ['required', new Enum(Friendly::class)],
            'description' => ['required', 'string'],
            'family_friendly' => ['required', new Enum(Friendly::class)],
            'gender' => ['required', new Enum(Gender::class)],
            'ibge_city_id' => ['required', 'integer'],
            'file' => ['sometimes', File::image()->max(5000)],
            'name' => ['required', 'string', 'max:255'],
            'pet_friendly' => ['required', new Enum(Friendly::class)],
            'playfulness' => ['required', new Enum(Playfulness::class)],
        ];
    }
}
