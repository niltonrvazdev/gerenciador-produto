<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Gera um nome único de produto com 2 palavras
            'name' => $this->faker->unique()->words(2, true),

            // Gera uma frase curta opcional
            'description' => $this->faker->sentence(),

            // Gera um preço decimal positivo entre 1 e 5000
            'price' => $this->faker->randomFloat(2, 0.01, 5000),

            // Gera uma quantidade inteira não negativa
            'stock' => $this->faker->numberBetween(0, 500),
        ];
    }
}
