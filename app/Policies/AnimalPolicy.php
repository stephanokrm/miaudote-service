<?php

namespace App\Policies;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnimalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Animal  $animal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Animal $animal)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * @param  User  $user
     * @param  Animal  $animal
     * @return bool
     */
    public function update(User $user, Animal $animal): bool
    {
        return $animal->user()->is($user);
    }

    /**
     * @param  User  $user
     * @param  Animal  $animal
     * @return bool
     */
    public function delete(User $user, Animal $animal): bool
    {
        return $animal->user()->is($user);
    }

    /**
     * @param  User  $user
     * @param  Animal  $animal
     * @return bool
     */
    public function restore(User $user, Animal $animal): bool
    {
        return $animal->user()->is($user);
    }

    /**
     * @param  User  $user
     * @param  Animal  $animal
     * @return bool
     */
    public function forceDelete(User $user, Animal $animal): bool
    {
        return $animal->user()->is($user);
    }
}
