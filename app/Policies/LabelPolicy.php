<?php

namespace App\Policies;

use App\Models\Label;
use App\Models\User;

class LabelPolicy
{
    public function store(User $user): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }

    public function update(User $user, Label $label): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }

    public function destroy(User $user, Label $label): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }
}
