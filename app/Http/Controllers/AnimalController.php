<?php

namespace App\Http\Controllers;

use App\Enums\Species;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;
use App\Models\Breed;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 *
 */
class AnimalController extends Controller
{
    /**
     * @var ImageService
     */
    private ImageService $imageService;

    /**
     * @param  ImageService  $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @return AnimalResource
     */
    public function index(): AnimalResource
    {
        return new AnimalResource(Animal::query()->latest('updated_at')->get());
    }

    /**
     * @param  StoreAnimalRequest  $request
     * @return AnimalResource
     */
    public function store(StoreAnimalRequest $request): AnimalResource
    {
        $breed = Breed::query()->firstOrCreate([
            'id' => $request->input('breed.id'),
            'name' => Str::lower($request->input('breed.name')),
            'species' => $request->enum('breed.species', Species::class),
        ]);

        $avatar = $this->imageService->upload($request->file('file'));

        $animal = new Animal();
        $animal->fill($request->all());
        $animal->setAttribute('avatar', $avatar);
        $animal->user()->associate(auth()->user());
        $animal->breed()->associate($breed);
        $animal->save();

        return new AnimalResource($animal);
    }

    /**
     * @param  Animal  $animal
     * @return AnimalResource
     */
    public function show(Animal $animal): AnimalResource
    {
        return new AnimalResource($animal->load('images', 'user:name,avatar'));
    }

    /**
     * @param  UpdateAnimalRequest  $request
     * @param  Animal  $animal
     * @return AnimalResource
     */
    public function update(UpdateAnimalRequest $request, Animal $animal): AnimalResource
    {
        $breed = Breed::query()->firstOrCreate([
            'id' => $request->input('breed.id'),
            'name' => Str::lower($request->input('breed.name')),
            'species' => $request->enum('breed.species', Species::class),
        ]);

        $animal->fill($request->all());
        $animal->user()->associate(auth()->user());
        $animal->breed()->associate($breed);

        if ($request->hasFile('file')) {
            $avatar = $this->imageService->upload($request->file('file'));

            $animal->setAttribute('avatar', $avatar);
        }

        $animal->save();

        if ($animal->wasChanged('avatar')) {
            $this->imageService->delete($animal->getOriginal('avatar'));
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
        return new AnimalResource($request->user()->animals()->latest('updated_at')->get());
    }
}
