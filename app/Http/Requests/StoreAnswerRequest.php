<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
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
        return collect($this->request->all())->map(function () {
            return [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    Question::query()->find($attribute)->existsOr(function () use ($fail) {
                        $fail('O pergunta selecionada é inválida.');
                    });
                },
            ];
        })->toArray();
    }
}
