<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanListPost()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/api/posts');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testEditorCanListPost()
    {
        $user = User::factory()->create(['role' => 'editor']);

        $response = $this->actingAs($user)->get('/api/posts');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGuestCanListPost()
    {
        $user = User::factory()->create(['role' => 'guest']);

        $response = $this->actingAs($user)->get('/api/posts');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanNotCreatePost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/api/posts', [
            'title' => 'Post Title',
            'content' => 'Post Content',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testEditorCanCreatePost()
    {
        $user = User::factory()->create(['role' => 'editor']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/api/posts', [
            'title' => 'Post Title',
            'content' => 'Post Content',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testGuestCanNotCreatePost()
    {
        $user = User::factory()->create(['role' => 'guest']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/api/posts', [
            'title' => 'Post Title',
            'content' => 'Post Content',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAdminCanShowPost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testEditorCanShowPost()
    {
        $user = User::factory()->create(['role' => 'editor']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGuestCanShowPost()
    {
        $user = User::factory()->create(['role' => 'guest']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanUpdatePost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->put("/api/posts/{$post->id}", [
            'title' => 'Post Title Updated',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testEditorCanUpdatePost()
    {
        $user = User::factory()->create(['role' => 'editor']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->put("/api/posts/{$post->id}", [
            'title' => 'Post Title Updated',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGuestCanNotUpdatePost()
    {
        $user = User::factory()->create(['role' => 'guest']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->put("/api/posts/{$post->id}", [
            'title' => 'Post Title Updated',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAdminCanDestroyPost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testEditorCanDestroyPost()
    {
        $user = User::factory()->create(['role' => 'editor']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testGuestCanNotDestroyPost()
    {
        $user = User::factory()->create(['role' => 'guest']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
