<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        $slug = Str::slug($name);
        $image = $this->faker->imageUrl(640, 480, 'Handmade', true, 'Category');

        return [
            'image' => $image,
            'slug'  => $slug,
        ];
    }

    // Creates a default PL translation (if you use translations table)
    public function configure(): CategoryFactory
    {
        return $this->afterCreating(function (Category $category) {
            // if you have a category_translations table with columns: locale, name, image_alt, label_meta, order, visible
            if (method_exists($category, 'translations')) {
                $category->translations()->create([
                    'locale'     => 'pl',
                    'name'       => 'Kategoria ' . $this->faker->word,
                    'image_alt'  => $this->faker->words(2, true),
                    'label_meta' => $this->faker->words(2, true),
                    'order'      => 1,
                    'visible'    => true,
                ]);
            }
        });
    }
}
