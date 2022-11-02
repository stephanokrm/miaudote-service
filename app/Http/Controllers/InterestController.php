<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnimalResource;
use App\Http\Resources\InterestResource;
use App\Models\Animal;

class InterestController extends Controller
{
    /**
     * @return AnimalResource
     */
    public function index(): AnimalResource
    {
        $animals = Animal::query()
            ->whereBelongsTo(auth()->user())
            ->whereHas('interests')
            ->latest()
            ->with('user')
            ->get();

        return new AnimalResource($animals);
    }

    /**
     * @param Animal $animal
     * @return bool
     */
    public function store(Animal $animal): bool
    {
        $animal->interests()->sync(auth()->user());

        return true;
    }

    /**
     * @return InterestResource
     */
    public function me(): InterestResource
    {
        return new InterestResource(auth()->user()->interests()->get());
    }
}
