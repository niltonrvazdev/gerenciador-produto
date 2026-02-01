<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductWebTest extends TestCase
{

    use RefreshDatabase;

    public function test_guest_connot_access_product_list()
    {
        $response = $this->get('/products');

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

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['name' => 'Monitor 4k']);
    }
}
