<?php

namespace App\Policies;

use App\Models\Agenda;
use App\Models\User;

class AgendaPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'Super Admin') {
            return true;
        }
        return null;
    }

    public function view(User $user, Agenda $agenda): bool
    {
        return $user->id === $agenda->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Agenda $agenda): bool
    {
        return $user->id === $agenda->user_id;
    }

    public function delete(User $user, Agenda $agenda): bool
    {
        return $user->id === $agenda->user_id;
    }
}