<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Animal;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;

class AnswerController extends Controller
{
    /**
     * @param Animal $animal
     * @param User $user
     * @return AnswerResource
     */
    public function index(Animal $animal, User $user): AnswerResource
    {
        $answers = Answer::query()->whereBelongsTo($animal)->whereBelongsTo($user)->with('question')->get();

        return new AnswerResource($answers);
    }

    /**
     * @param Animal $animal
     * @param StoreAnswerRequest $request
     * @return bool
     */
    public function store(Animal $animal, StoreAnswerRequest $request): bool
    {
        $user = auth()->user();

        collect($request->all())->each(function ($value, $question) use ($animal, $user) {
            $question = Question::query()->find($question);

            $answer = new Answer();
            $answer->setAttribute('value', $value);
            $answer->animal()->associate($animal);
            $answer->question()->associate($question);
            $answer->user()->associate($user);
            $answer->save();
        });

        $animal->interests()->attach($user);

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAnswerRequest $request
     * @param \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
