<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @param Answer $answer
     * @return bool
     */
    public function view(User $user, Answer $answer): bool
    {
        return $answer->user()->is($user);
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
     * @param User $user
     * @param Answer $answer
     * @return bool
     */
    public function update(User $user, Answer $answer): bool
    {
        return $answer->user()->is($user);
    }

    /**
     * @param User $user
     * @param Answer $answer
     * @return bool
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $answer->user()->is($user);
    }

    /**
     * @param User $user
     * @param Answer $answer
     * @return bool
     */
    public function restore(User $user, Answer $answer): bool
    {
        return $answer->user()->is($user);
    }

    /**
     * @param User $user
     * @param Answer $answer
     * @return bool
     */
    public function forceDelete(User $user, Answer $answer): bool
    {
        return $answer->user()->is($user);
    }
}
