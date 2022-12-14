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
     * @return array
     */
    public function rules(): array
    {
        $before = Carbon::today()->addDay()->format('Y-m-d');
        $after = Carbon::today()->subYears(30)->format('Y-m-d');

        return [
            'file' => ['required', File::image()->max(5000)],
            'avatar' => ['sometimes', 'string'],
            'born_at' => ['required', 'date', "before_or_equal:{$before}", "after_or_equal:{$after}"],
            'breed.id' => ['nullable', 'required_without:breed.name', 'uuid', Rule::exists('breeds', 'id')],
            'breed.name' => ['nullable', 'required_without:breed.id', 'string'],
            'breed.species' => ['required', new Enum(Species::class)],
            'children_friendly' => ['required', new Enum(Friendly::class)],
            'description' => ['required', 'string'],
            'family_friendly' => ['required', new Enum(Friendly::class)],
            'gender' => ['required', new Enum(Gender::class)],
            'ibge_city_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'pet_friendly' => ['required', new Enum(Friendly::class)],
            'playfulness' => ['required', new Enum(Playfulness::class)],
            'castrated' => ['required', 'boolean'],
        ];
    }
}
