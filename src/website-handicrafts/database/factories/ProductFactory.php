<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

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
        $name = $this->faker->unique()->words(2, true);
        $slug = Str::slug($name);

        return [
            // set a category by default; can be overridden in tests via ->for($category)
            'category_id'     => Category::factory(),
            'default_price'   => $this->faker->randomFloat(2, 1, 1000),
            'default_currency' => 'PLN',
            'stock_quantity'  => $this->faker->numberBetween(0, 100),
            'slug'            => $slug,
        ];
    }

    public function configure(): ProductFactory
    {
        return $this->afterCreating(function (Product $product) {
            // if you have a product_translations table
            if (method_exists($product, 'translations')) {
                $product->translations()->create([
                    'locale'      => 'pl',
                    'name'        => 'Produkt ' . $this->faker->word,
                    'short_name'  => $this->faker->word,
                    'description' => $this->faker->sentence,
                    'price'       => $product->default_price,
                    'currency'    => $product->default_currency ?? 'PLN',
                    'order'       => 1,
                    'visible'     => true,
                ]);
            }
        });
    }
}
