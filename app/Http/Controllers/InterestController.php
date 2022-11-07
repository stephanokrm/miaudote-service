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
        $animal->interests()->attach(auth()->user());

        return true;
    }

    /**
     * @param Animal $animal
     * @return bool
     */
    public function show(Animal $animal): bool
    {
        if (!auth()->hasUser()) return false;

        return $animal
            ->interests()
            ->wherePivot('user_id', auth()->user()->getAuthIdentifier())
            ->exists();
    }

    /**
     * @param Animal $animal
     * @return bool
     */
    public function destroy(Animal $animal): bool
    {
        $animal->interests()->detach(auth()->user());

        return true;
    }

    /**
     * @return InterestResource
     */
    public function me(): InterestResource
    {
        return new InterestResource(auth()->user()->interests()->with('user')->get());
    }
}
