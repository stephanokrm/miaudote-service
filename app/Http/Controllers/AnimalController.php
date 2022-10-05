<?php

namespace App\Http\Controllers;

use App\Enums\Species;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Image;
use Illuminate\Support\Str;

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
        $breed = Breed::query()->firstOrCreate([
            'name' => Str::lower($request->input('breed')),
            'species' => $request->enum('species', Species::class),
        ]);

        $animal = new Animal();
        $animal->fill($request->all());
        $animal->user()->associate(auth()->user());
        $animal->breed()->associate($breed);
        $animal->save();

        $image = new Image();
        $image->fill($request->all());
        $image->setAttribute('url', $request->file('image')->storePublicly('uploads'));
        $image->profile()->associate($animal);
        $image->save();

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
