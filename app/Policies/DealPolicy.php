<?php

namespace App\Policies;

use     App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DealPolicy
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
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Deal $deal)
    {
        return $user->id===$deal->author_id || $deal->isMember($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Deal $deal)
    {
        return $user->id===$deal->author_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Deal $deal)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Deal $deal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Deal $deal)
    {
        //
    }

    /**
     * Determine whether the user can approve status the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function approve(User $user, Deal $deal)
    {
        return $deal->status==='awaiting' && $deal->isMember($user);
    }

    /**
     * Determine whether the user can reject status the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reject(User $user, Deal $deal)
    {
        return $deal->status === 'awaiting' && $deal->isMember($user);
    }

    public function postReply(User $user, Deal $deal)
    {
        return $deal->status !== 'rejected' && $deal->isMember($user);
    }

    public function close(User $user, Deal $deal)
    {
        return $deal->status === 'open' && $deal->author() === $user;
    }
}
