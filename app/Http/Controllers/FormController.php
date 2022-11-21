<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Resources\FormResource;
use App\Models\Animal;
use App\Models\Form;

class FormController extends Controller
{
    /**
     * @return FormResource
     */
    public function index(): FormResource
    {
        $forms = Form::query()->whereBelongsTo(auth()->user())->get();

        return new FormResource($forms);
    }

    /**
     * @param StoreFormRequest $request
     * @return FormResource
     */
    public function store(StoreFormRequest $request): FormResource
    {
        $form = new Form();
        $form->fill($request->all());
        $form->user()->associate(auth()->user());
        $form->save();

        return new FormResource($form);
    }

    /**
     * @param Form $form
     * @return FormResource
     */
    public function show(Form $form): FormResource
    {
        return new FormResource($form);
    }

    /**
     * @param Animal $animal
     * @return FormResource
     */
    public function animal(Animal $animal): FormResource
    {
        $breed = $animal->breed()->firstOrFail();
        $user = $animal->user()->firstOrFail();

        $form = Form::query()
            ->whereBelongsTo($user)
            ->where('species', $breed->getAttribute('species'))
            ->with('questions')
            ->firstOrFail();

        return new FormResource($form);
    }
}
