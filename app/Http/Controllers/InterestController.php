<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInterestRequest;
use App\Http\Resources\InterestResource;
use App\Models\Animal;
use App\Models\Interest;

class InterestController extends Controller
{
    /**
     * @return InterestResource
     */
    public function index(): InterestResource
    {
        $animals = Animal::query()->whereBelongsTo(auth()->user())->get();
        $interests = Interest::query()->whereBelongsTo($animals)->get();

        return new InterestResource($interests);
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
     * @param  Interest  $interest
     * @return InterestResource
     */
    public function show(Interest $interest): InterestResource
    {
        return new InterestResource($interest);
    }

    /**
     * @param  UpdateInterestRequest  $request
     * @param  Interest  $interest
     * @return InterestResource
     */
    public function update(UpdateInterestRequest $request, Interest $interest): InterestResource
    {
        return new InterestResource($interest);
    }

    /**
     * @param  Interest  $interest
     * @return InterestResource
     */
    public function destroy(Interest $interest): InterestResource
    {
        $interest->delete();

        return new InterestResource($interest);
    }

    /**
     * @return InterestResource
     */
    public function me(): InterestResource
    {
        return new InterestResource(auth()->user()->interests()->get());
    }
}
