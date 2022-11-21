<?php

namespace App\Http\Requests;

use App\Enums\Species;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Unique;

class StoreFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        $unique = (new Unique('forms'))
            ->where('user_id', auth()->user()->getAuthIdentifier());

        return [
            'species' => ['required', new Enum(Species::class), $unique],
        ];
    }
}
