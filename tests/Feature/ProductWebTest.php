<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_product_list()
    {
        // Mudamos o teste: agora o guest DEVE conseguir acessar (Status 200)
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_create_page()
    {
        // Testamos uma rota que continua protegida
        $response = $this->get('/products/create');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_product()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/products', [
            'name' => 'Monitor 4k',
            'price' => 2500.00,
            'stock' => 5,
            'description' => 'Monitor Ultra HD 4k de 43 polegadas',
        ]);

        // O redirecionamento agora é para a rota 'products.index' que é '/'
        $response->assertRedirect('/');
        $this->assertDatabaseHas('products', ['name' => 'Monitor 4k']);
    }
}
