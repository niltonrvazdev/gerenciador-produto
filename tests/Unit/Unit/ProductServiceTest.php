<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProductService();
    }

    public function test_it_can_create_a_product()
    {
        $data = [
            'name' => 'Playstation 5',
            'price' => 3799.99,
            'stock' => 13,
            'description' => 'Console da Sony de última geração',
        ];

        $product = $this->service->createProduct($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Playstation 5', $product->name);

        $this->assertDatabaseHas('products', ['name' => 'Playstation 5', 'price' => 3799.99]);
    }

    public function test_it_can_update_a_product()
    {
        $product = Product::create([
            'name' => 'Xbox Series S',
            'price' => 4299.99,
            'stock' => 10,
            'description' => 'Console da Microsoft de última geração',
        ]);

        $updateData = [
            'name' => 'Xbox Series X Extreme',
            'price' => 5999.99,
            'stock' => 15,
            'description' => 'Console Extreme da Microsoft Xbox Series X ',
        ];
        $updatedProduct = $this->service->updateProduct($product, $updateData);

        $this->assertEquals('Xbox Series X Extreme', $updatedProduct->name);
        $this->assertDatabaseHas('products', ['name' => 'Xbox Series X Extreme']);
    }


    /**@test */
    public function test_it_can_delete_a_product()
    {
        $product = Product::create([
            'name' => 'Nintendo Switch',
            'price' => 2999.99,
            'stock' => 20,
            'description' => 'Console portátil da Nintendo',
        ]);

     $result = $this->service->deleteProduct($product);
        $this->assertTrue($result);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
