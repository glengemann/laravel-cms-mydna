<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function testNonAuthenticatedUserCanListCategory()
    {
        $response = $this->get('/api/categories');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGuestCanListCategory()
    {
        $user = User::factory()->create(['role' => 'guest']);

        $response = $this->actingAs($user)->get('/api/categories');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanCreateCategory()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post('/api/categories', [
            'name' => 'Category Name',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testNonAuthenticatedUserCanNotCreateCategory()
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Category Name',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanShowCategory()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->get("/api/categories/{$category->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testNonAuthenticatedUserCanShowCategory()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanUpdateCategory()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->put("/api/categories/{$category->id}", [
                'name' => 'Category Name',
            ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testNonAuthenticatedUserCanNotUpdateCategory()
    {
        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Category Name',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanDestroyCategory(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->delete("/api/categories/{$category->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testNonAuthenticatedUserCanNotDestroyCategory(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
