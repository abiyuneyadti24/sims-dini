<?php

namespace App\Policies;

use App\Models\LogNilai;
use App\Models\User;

class LogNilaiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LogNilai $logNilai): bool
    {
        return $user->isAdmin();
    }

    /**
     * Riwayat hanya dibuat oleh NilaiObserver, tidak lewat panel.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Riwayat tidak boleh diubah siapa pun, termasuk admin.
     */
    public function update(User $user, LogNilai $logNilai): bool
    {
        return false;
    }

    /**
     * Riwayat tidak boleh dihapus siapa pun, termasuk admin.
     */
    public function delete(User $user, LogNilai $logNilai): bool
    {
        return false;
    }

    /**
     * Determine whether the user can bulk delete models.
     */
    public function deleteAny(User $user): bool
    {
        return false;
    }
}
