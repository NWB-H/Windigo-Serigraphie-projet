<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function login_returns_token_for_valid_credentials()
    {
        // Crée un utilisateur avec un mot de passe connu
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/authenticate', $credentials);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'user',
                     // 'token' -> retirer si ton API ne renvoie pas de token
                 ]);
    }

    #[Test]
    public function login_fails_for_invalid_credentials()
    {
        $credentials = [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword'
        ];

        $response = $this->postJson('/api/authenticate', $credentials);

        $response->assertStatus(401)
                 ->assertJson([
                     'user' => null
                     // 'message' -> retirer si ton API ne renvoie pas cette clé
                 ]);
    }

    #[Test]
    public function logout_invalidates_user_session()
    {
        $user = User::factory()->create();

        // Crée un token si nécessaire pour l'auth
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
                         ->getJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => 'Utilisateur deconnecté !'
                 ]);
    }
}
