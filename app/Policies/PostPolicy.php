<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function store(User $user): bool
    {
        return $user->isEditor();
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }

    public function destroy(User $user, Post $post): bool
    {
        return $user->isEditor() || $user->isAdmin();
    }
}
