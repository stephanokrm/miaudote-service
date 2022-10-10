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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'born_at' => ['required', 'date', "before_or_equal:{$before}", "after_or_equal:{$after}"],
            'gender' => ['required', new Enum(Gender::class)],
            'playfulness' => ['required', new Enum(Playfulness::class)],
            'family_friendly' => ['required', new Enum(Friendly::class)],
            'pet_friendly' => ['required', new Enum(Friendly::class)],
            'children_friendly' => ['required', new Enum(Friendly::class)],
            'ibge_city_id' => ['required', 'integer'],
            'breed_species' => ['required', new Enum(Species::class)],
            'breed_name' => ['required_without:breed_id', 'string'],
            'breed_id' => ['required_without:breed_name', 'uuid', Rule::exists('breeds', 'id')],
            'image' => ['sometimes', File::image()->max(5000)],
        ];
    }
}
