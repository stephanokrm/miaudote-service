<?php

namespace App\Policies;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnimalPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param Animal $animal
     * @return bool
     */
    public function view(User $user, Animal $animal): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
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
