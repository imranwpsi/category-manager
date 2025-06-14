<?php

use Ihossain\CategoryManager\Models\Category;

it('can create a category', function () {
    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true
    ]);

    expect($category->name)->toBe('Test Category');
    expect($category->slug)->toBe('test-category');
    expect($category->is_active)->toBeTrue();
});

it('can have a parent category', function () {
    $parent = Category::create(['name' => 'Parent', 'slug' => 'parent']);
    $child = Category::create(['name' => 'Child', 'slug' => 'child', 'parent_id' => $parent->id]);

    expect($child->parent)->toBeInstanceOf(Category::class);
    expect($child->parent->name)->toBe('Parent');
    expect($parent->children)->toHaveCount(1);
});

it('can be scoped by type', function () {
    Category::factory()->create(['type' => 'blog']);
    Category::factory()->create(['type' => 'product']);

    expect(Category::ofType('blog')->count())->toBe(1);
    expect(Category::ofType('product')->count())->toBe(1);
});

it('can have meta data', function () {
    $category = Category::create([
        'name' => 'Meta Category',
        'slug' => 'meta-category',
        'meta' => ['color' => '#ff0000', 'icon' => 'test']
    ]);

    expect($category->meta['color'])->toBe('#ff0000');
    expect($category->meta['icon'])->toBe('test');
});
