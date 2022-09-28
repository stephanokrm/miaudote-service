<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterestRequest;
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
        $interests = Interest::query()->whereBelongsTo(auth()->user())->get();

        return new InterestResource($interests);
    }

    /**
     * @param  StoreInterestRequest  $request
     * @return InterestResource
     */
    public function store(StoreInterestRequest $request): InterestResource
    {
        $animal = Animal::query()->findOrFail($request->input('animal_id'));

        $interest = new Interest();
        $interest->fill($request->all());
        $interest->users()->save(auth()->user());
        $interest->animals()->save($animal);
        $interest->save();

        return new InterestResource($interest);
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
}
