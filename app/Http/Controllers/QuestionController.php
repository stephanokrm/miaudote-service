<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Form;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * @param Form $form
     * @return QuestionResource
     */
    public function index(Form $form): QuestionResource
    {
        $questions = Question::query()->whereBelongsTo($form)->get();

        return new QuestionResource($questions);
    }

    /**
     * @param Form $form
     * @param StoreQuestionRequest $request
     * @return QuestionResource
     */
    public function store(Form $form, StoreQuestionRequest $request): QuestionResource
    {
        $question = new Question();
        $question->fill($request->all());
        $question->form()->associate($form);
        $question->save();

        return new QuestionResource($question);
    }

    /**
     * @param Question $question
     * @return bool
     */
    public function destroy(Question $question): bool
    {
        $question->delete();

        return true;
    }
}
