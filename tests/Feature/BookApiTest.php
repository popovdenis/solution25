<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authHeaders(): array
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);
        return ['Authorization' => "Bearer {$token}"];
    }

    public function test_crud_and_validation(): void
    {
        $headers = $this->authHeaders();

        // CREATE
        $create = $this->withHeaders($headers)->postJson('/api/books', [
            'title'=>'T','author'=>'A','publication_year'=>2020
        ]);
        $create->assertCreated()->assertJsonPath('data.title','T');
        $id = $create->json('data.id');

        // DUPLICATE (same owner)
        $this->withHeaders($headers)->postJson('/api/books', [
            'title'=>'T','author'=>'A','publication_year'=>2020
        ])->assertStatus(422);

        // READ
        $this->withHeaders($headers)->getJson("/api/books/{$id}")
            ->assertOk()->assertJsonPath('data.author','A');

        // UPDATE
        $this->withHeaders($headers)->putJson("/api/books/{$id}", ['title'=>'TT'])
            ->assertOk()->assertJsonPath('data.title','TT');

        // INDEX
        $this->withHeaders($headers)->getJson('/api/books?per_page=5&sort=-publication_year')
            ->assertOk()->assertJsonStructure(['data','links','meta']);

        // DELETE
        $this->withHeaders($headers)->deleteJson("/api/books/{$id}")
            ->assertNoContent();
    }
}
