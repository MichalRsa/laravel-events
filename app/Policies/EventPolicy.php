<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Event $event): bool
    {
        // Check if the user is part of the team associated with the event
        return $user->belongsToTeam($event->team);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Event $event): bool
    {
        return $event->user_id === Auth::user()->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Event $event): bool
    {
        return $event->user_id === Auth::user()->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        //
    }
}
