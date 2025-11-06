<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Technician]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Technician]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can update the ticket status.
     */
    public function updateStatus(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can update the ticket priority.
     */
    public function updatePriority(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can assign users to the ticket.
     */
    public function assignUser(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::Admin;
    }

    /**
     * Determine whether the user can add notes to the ticket.
     */
    public function addNote(User $user, Ticket $ticket): bool
    {
        return in_array($user->role, [UserRole::Admin, UserRole::Technician]);
    }
}
