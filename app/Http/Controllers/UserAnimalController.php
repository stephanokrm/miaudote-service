<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnimalResource;
use App\Models\User;

/**
 *
 */
class UserAnimalController extends Controller
{
    /**
     * @param  User  $user
     * @return AnimalResource
     */
    public function index(User $user): AnimalResource
    {
        return new AnimalResource($user->animals()->get());
    }
}
