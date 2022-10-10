<?php

namespace App\Http\Controllers;

use App\Enums\Species;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Intervention;

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

        $uploaded = $request->file('image');

        $path = "uploads/{$uploaded->hashName()}";

        Storage::put(
            $path,
            Intervention::make($uploaded->path())->fit(500)->encode()->getEncoded(),
            ['visibility' => 'public']
        );

        $image = new Image();
        $image->fill($request->all());
        $image->setAttribute('url', $path);
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
        $breed = Breed::query()->firstOrCreate([
            'id' => $request->input('breed_id'),
            'name' => Str::lower($request->input('breed_name')),
            'species' => $request->enum('breed_species', Species::class),
        ]);

        $animal->fill($request->all());
        $animal->user()->associate(auth()->user());
        $animal->breed()->associate($breed);
        $animal->save();

        if ($request->hasFile('image')) {
            $uploaded = $request->file('image');

            $path = "uploads/{$uploaded->hashName()}";

            Storage::put(
                $path,
                Intervention::make($uploaded->path())->fit(500)->encode()->getEncoded(),
                ['visibility' => 'public']
            );

            $image = new Image();
            $image->fill($request->all());
            $image->setAttribute('url', $path);
            $image->profile()->associate($animal);
            $image->save();
        }

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

    /**
     * @param  Request  $request
     * @return AnimalResource
     */
    public function me(Request $request): AnimalResource
    {
        return new AnimalResource($request->user()->animals()->get());
    }
}
