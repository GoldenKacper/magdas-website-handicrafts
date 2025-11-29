<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Product;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_category(): void
    {
        // Create a category
        $category = Category::factory()->create();

        // Create a product assigned to this category (method 1)
        $product = Product::factory()->for($category)->create();

        // or : Product::factory()->create(['category_id' => $category->id]);

        // assert (Eloquent ->is checks model identity)
        $this->assertTrue($product->category->is($category));

        // additionally: make sure the relationship loads the correct id
        $this->assertEquals($category->id, $product->category->id);
    }
}
