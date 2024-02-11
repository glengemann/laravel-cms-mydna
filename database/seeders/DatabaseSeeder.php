<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Label;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@cms.com',
            'role' => Role::ADMIN->value,
        ]);

        User::factory()->create([
            'email' => 'editor@cms.com',
            'role' => Role::ADMIN->value,
        ]);

        User::factory()->create([
            'email' => 'guest@cms.com',
            'role' => Role::GUEST->value,
        ]);

        User::factory(10)->create();

        Category::factory(10)->create()->each(function ($category) {
            $random = rand(1, 5);
            $category->posts()->saveMany(Post::factory($random)->make(
                [
                    'user_id' => User::inRandomOrder()->first()->id,
                ]
            ));
        });

        Label::factory(15)->create()->each(function ($label) {
            $random = rand(1, 3);
            $label->posts()->attach(Post::inRandomOrder()->limit($random)->get());
        });

        Post::all()->each(function ($post) {
            $random = rand(1, 8);
            $post->comments()->saveMany(Comment::factory($random)->make(
                ['user_id' => User::inRandomOrder()->first()->id]
            ));
        });
    }
}
