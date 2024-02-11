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

    public function testAdminCanCreatePost()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/api/posts', [
            'title' => 'Post Title',
            'content' => 'Post Content',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
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
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testEditorCanShowPost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'editor']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGuestCanShowPost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'guest']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->get("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanUpdatePost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->put("/api/posts/{$post->id}", [
            'title' => 'Post Title Updated',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testEditorCanUpdatePost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'editor']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->put("/api/posts/{$post->id}", [
            'title' => 'Post Title Updated',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGuestCanNotUpdatePost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'guest']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->put("/api/posts/{$post->id}", [
            'title' => 'Post Title Updated',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testAdminCanDestroyPost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testEditorCanDestroyPost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'editor']);
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->delete("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testNonAuthenticatedUserCanNotDestroyPost(): void
    {
        $this->markTestSkipped('Check the creating event.');
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testGuestCanNotDestroyPost()
    {
        $this->markTestSkipped('Check the creating event.');
        $user = User::factory()->create(['role' => 'guest']);
        $post = Post::factory()->make();

        $response = $this->actingAs($user)
            ->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
