<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Http\Response;

class LabelControllerTest extends TestCase
{
    public function testNonAuthenticatedUserCanList()
    {
        $response = $this->getJson('/api/labels');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanList()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)
            ->getJson('/api/labels');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanCreate()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)
            ->postJson('/api/labels', [
                'name' => 'Label Name',
            ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testNonAuthenticatedUserCanNotCreate()
    {
        $response = $this->postJson('/api/labels', [
            'name' => 'Label Name',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanShow()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $label = Label::factory()->create();

        $response = $this->actingAs($user)
            ->getJson("/api/labels/{$label->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testNonAuthenticatedUserCanShow()
    {
        $label = Label::factory()->create();

        $response = $this->getJson("/api/labels/{$label->id}");

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testAdminCanUpdate()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $label = Label::factory()->create();

        $response = $this->actingAs($user)
            ->putJson("/api/labels/{$label->id}", [
                'name' => 'New Label Name',
            ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testNonAuthenticatedUserCanNotUpdate()
    {
        $user = User::factory()->create(['role' => 'guest']);
        $label = Label::factory()->create();

        $response = $this->actingAs($user)
            ->putJson("/api/labels/{$label->id}", [
                'name' => 'New Label Name',
            ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testGuestUserCanNotUpdate()
    {
        $label = Label::factory()->create();

        $response = $this->putJson("/api/labels/{$label->id}", [
            'name' => 'New Label Name',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanDelete()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $label = Label::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson("/api/labels/{$label->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testNonAuthenticatedUserCanNotDelete()
    {
        $label = Label::factory()->create();

        $response = $this->deleteJson("/api/labels/{$label->id}");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testGuestUserCanNotDelete()
    {
        $user = User::factory()->create(['role' => 'guest']);
        $label = Label::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson("/api/labels/{$label->id}");

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
