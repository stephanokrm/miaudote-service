<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;

class AnimalController extends Controller
{
    /**
     * @return AnimalResource
     */
    public function index(): AnimalResource
    {
        return new AnimalResource(Animal::all());
    }

    /**
     * @param  StoreAnimalRequest  $request
     * @return AnimalResource
     */
    public function store(StoreAnimalRequest $request): AnimalResource
    {
        $animal = new Animal();
        $animal->fill($request->all());
        $animal->user()->associate(auth()->user());
        $animal->save();

        return new AnimalResource($animal);
    }

    /**
     * @param  Animal  $animal
     * @return AnimalResource
     */
    public function show(Animal $animal): AnimalResource
    {
        return new AnimalResource($animal);
    }

    /**
     * @param  UpdateAnimalRequest  $request
     * @param  Animal  $animal
     * @return AnimalResource
     */
    public function update(UpdateAnimalRequest $request, Animal $animal): AnimalResource
    {
        $animal->fill($request->all());
        $animal->save();

        return new AnimalResource($animal);
    }

    /**
     * @param  Animal  $animal
     * @return AnimalResource
     */
    public function destroy(Animal $animal): AnimalResource
    {
        $animal->delete();

        return new AnimalResource($animal);
    }
}
