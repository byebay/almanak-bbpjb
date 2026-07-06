<?php
namespace App\Policies;

use App\Models\Agenda;
use App\Models\User;

class AgendaPolicy
{
    /**
     * Super Admin bisa melakukan apa saja.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Tentukan apakah user bisa melihat agenda.
     * (Semua user yang login bisa melihat semua agenda)
     */
    public function view(User $user, Agenda $agenda): bool
    {
        return true;
    }

    /**
     * Tentukan apakah user bisa mengupdate agenda.
     * (Hanya pembuat agenda yang bisa)
     */
    public function update(User $user, Agenda $agenda): bool
    {
        return $user->id === $agenda->user_id;
    }

    /**
     * Tentukan apakah user bisa menghapus agenda.
     * (Hanya pembuat agenda yang bisa)
     */
    public function delete(User $user, Agenda $agenda): bool
    {
        return $user->id === $agenda->user_id;
    }
}
