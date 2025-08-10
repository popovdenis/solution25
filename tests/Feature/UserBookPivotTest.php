<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBookPivotTest extends TestCase
{
    use RefreshDatabase;

    protected function authHeadersFor(User $user): array
    {
        $token = auth('api')->login($user);
        return ['Authorization' => "Bearer {$token}"];
    }

    public function test_attach_list_available_and_detach(): void
    {
        $owner = User::factory()->create();
        $u1 = User::factory()->create();
        $headers = $this->authHeadersFor($u1);

        // owner creates a book
        $tokenOwner = auth('api')->login($owner);
        $this->withHeaders(['Authorization'=>"Bearer {$tokenOwner}"])
            ->postJson('/api/books', ['title'=>'T','author'=>'A','publication_year'=>2020])
            ->assertCreated();
        $bookId = \App\Models\Book::first()->id;

        // available for the binding
        $this->withHeaders($headers)->getJson('/api/me/books/available')
            ->assertOk()->assertJsonFragment(['id'=>$bookId]);

        // bind
        $this->withHeaders($headers)->postJson('/api/me/books', ['book_id'=>$bookId])
            ->assertCreated();

        // binding existing is prohibit
        $this->withHeaders($headers)->postJson('/api/me/books', ['book_id'=>$bookId])
            ->assertStatus(422);

        // now the book should not be available
        $this->withHeaders($headers)->getJson('/api/me/books/available')
            ->assertOk()->assertJsonMissing(['id'=>$bookId]);

        // the list of bound books
        $this->withHeaders($headers)->getJson('/api/me/books')
            ->assertOk()->assertJsonFragment(['id'=>$bookId]);

        // unbind
        $this->withHeaders($headers)->deleteJson("/api/me/books/{$bookId}")
            ->assertNoContent();
    }
}
