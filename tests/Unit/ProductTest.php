<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Option;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Option $option;
    private Category $category;

    public function setUp(): void
    {
        parent::setUp();

        // Création d'un utilisateur admin
        $this->user = User::factory()->create();

        // Création d'une option et d'une catégorie pour le produit
        $this->option = Option::factory()->create();
        $this->category = Category::factory()->create();

        // Création de 3 produits pour tester l'index
        Product::factory()->count(3)->create([
            'option_id' => $this->option->id,
            'category_id' => $this->category->id,
            'archived' => false, // valeur par défaut
        ]);
    }

    #[Test]
    public function index()
    {
        $response = $this->actingAs($this->user)->getJson('/api/admin/products');

        $response->assertStatus(200);

        $json = $response->json();

        // Vérifie que c'est un tableau et qu'il contient 3 éléments
        $this->assertIsArray($json, 'La réponse JSON doit être un tableau');
        $this->assertCount(3, $json, 'Il doit y avoir exactement 3 produits');
    }

    #[Test]
    public function store()
    {
        $payload = [
            'name' => 'T-shirt sérigraphié',
            'price' => 20,
            'stock' => 10,
            'description' => 'Super T-shirt pour tous les goûts',
            'option_id' => $this->option->id,
            'category_id' => $this->category->id,
            'archived' => false
        ];

        $response = $this->actingAs($this->user)
                         ->postJson('/api/admin/products', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'T-shirt sérigraphié']);

        $this->assertDatabaseHas('products', ['name' => 'T-shirt sérigraphié']);
    }

    #[Test]
    public function update()
    {
        $product = Product::first();

        $payload = [
            'name' => 'T-shirt modifié',
            'price' => 25,
            'stock' => 5,
            'description' => 'T-shirt mis à jour',
            'option_id' => $this->option->id,
            'category_id' => $this->category->id,
            'archived' => false
        ];

        $response = $this->actingAs($this->user)
                         ->putJson("/api/admin/products/{$product->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'T-shirt modifié']);

        $this->assertDatabaseHas('products', ['name' => 'T-shirt modifié']);
    }

    #[Test]
    public function delete_product()
    {
        $product = Product::first();

        $response = $this->actingAs($this->user)
                         ->deleteJson("/api/admin/products/{$product->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
