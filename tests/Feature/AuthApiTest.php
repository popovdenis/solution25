<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login(): void
    {
        $this->postJson('/api/auth/register', [
            'name'=>'Denis','email'=>'denis@example.com','password'=>'secret123',
        ])->assertCreated();

        $this->postJson('/api/auth/login', [
            'email'=>'denis@example.com','password'=>'secret123',
        ])->assertOk()->assertJsonStructure(['access_token','token_type','expires_in']);
    }
}
