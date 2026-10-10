<?php

namespace App\Policies;

use App\Models\Nilai;
use App\Models\User;

class NilaiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'guru', 'kepala_sekolah', 'orang_tua']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Nilai $nilai): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'guru']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Nilai $nilai): bool
    {
        // Guru hanya boleh mengubah nilai yang ia input sendiri
        return $user->isAdmin()
            || ($user->isGuru() && $nilai->guru_id === $user->guru?->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Nilai $nilai): bool
    {
        // Nilai yang sudah punya riwayat perubahan tidak boleh dihapus
        return $user->isAdmin() && ! $nilai->logNilai()->exists();
    }

    /**
     * Determine whether the user can bulk delete models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
