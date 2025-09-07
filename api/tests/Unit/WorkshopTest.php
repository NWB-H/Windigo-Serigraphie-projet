<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class WorkshopTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        // Création d'un utilisateur admin
        $this->user = User::factory()->create();

        // Création de 2 workshops pour tester l'index
        Workshop::factory()->count(2)->create([
            'name' => 'durand.fr',
            'type' => 'TEXTILE',
            'price' => 9,
            'duration' => '02:00:00',
            'age' => 15
        ]);
    }

    #[Test]
    public function index()
    {
        $response = $this->actingAs($this->user)->getJson('/api/admin/workshops');

        $response->assertStatus(200);

        $json = $response->json();
        $this->assertIsArray($json, 'La réponse JSON doit être un tableau');
        $this->assertCount(2, $json, 'Il doit y avoir exactement 2 workshops');
    }

    #[Test]
    public function delete_workshop()
    {
        $workshop = Workshop::first();

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/admin/workshops/{$workshop->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('workshops', ['id' => $workshop->id]);
    }
}
