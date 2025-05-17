<?php

namespace Imranwpsi\CategoryManager\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Imranwpsi\CategoryManager\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'is_active' => true,
            'type' => $this->faker->randomElement(['blog', 'product']),
            'meta' => null,
        ];
    }
}
