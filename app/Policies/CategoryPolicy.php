<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function store(User $user): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }

    public function update(User $user, Category $category): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }

    public function destroy(User $user, Category $category): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }
}
