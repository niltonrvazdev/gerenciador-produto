<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum; // Importação limpa
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_requires_authentication()
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(401);
    }

    /**
     * Testa a listagem de produtos.
     */
    public function test_api_can_list_products()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'name', 'description', 'price', 'stock', 'created_at'] // Removido updated_at
                    ],
                ]);
    }

    /**
     * Testando criação de um produto usando API com sucesso.
     */
    public function test_api_can_create_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'name' => 'Cubo magico',
            'price' => 29.90,
            'stock' => 20,
            'description' => 'Cubo magico 3x3 de alta qualidade.',
        ];

        $response = $this->postJson('/api/products', $data);

        // CORREÇÃO: assertStatus(201) e assertJsonPath para validar o VALOR
        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Cubo magico');

        $this->assertDatabaseHas('products', ['name' => 'Cubo magico']);
    }

    /**
     * Testa a validação de erros na API.
     */
    public function test_api_validation_errors()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/products', [
            'name' => '',
            'price' => -10,
            'stock' => 'abc',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'price', 'stock']);
    }

    /**
     * Testa a atualização de um produto via API.
     */
    public function test_api_can_update_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Cubo magico atualizado',
            'price' => 34.90,
            'stock' => 15,
            'description' => 'Descricao atualizada',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'Cubo magico atualizado']);
    }

    /**
     * Testa a exclusão de um produto via API.
     */
    public function test_api_can_delete_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
