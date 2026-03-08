<?php

use Ihossain\CategoryManager\CategoryManager;
use Ihossain\CategoryManager\Models\Category;

it('can manage category hierarchy', function () {
    $parent = Category::create(['name' => 'Parent', 'slug' => 'parent']);
    $child1 = Category::create(['name' => 'Child 1', 'slug' => 'child-1', 'parent_id' => $parent->id]);
    $child2 = Category::create(['name' => 'Child 2', 'slug' => 'child-2', 'parent_id' => $parent->id]);

    $parent->load('children');

    expect($parent->children)->toHaveCount(2);
    expect($parent->children->first()->name)->toBe('Child 1');
    expect($parent->children->last()->name)->toBe('Child 2');
});

it('maintains unique slugs', function () {
    Category::create(['name' => 'Test', 'slug' => 'test']);

    expect(fn () => Category::create(['name' => 'Test', 'slug' => 'test']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});

it('can be ordered', function () {
    $cat1 = Category::create(['name' => 'First', 'slug' => 'first', 'order' => 2]);
    $cat2 = Category::create(['name' => 'Second', 'slug' => 'second', 'order' => 1]);

    $ordered = Category::orderBy('order')->get();

    expect($ordered->first()->name)->toBe('Second');
    expect($ordered->last()->name)->toBe('First');
});

it('can create a product category', function () {
    $manager = new CategoryManager;

    $category = $manager->createProductCategory([
        'name' => 'Electronics',
        'description' => 'Electronic products',
    ]);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->type)->toBe('product')
        ->and($category->slug)->toBe('electronics')
        ->and($category->is_active)->toBeTrue();
});

it('can create a post category', function () {
    $manager = new CategoryManager;

    $category = $manager->createPostCategory([
        'name' => 'Technology',
        'description' => 'Tech blog posts',
    ]);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->type)->toBe('blog')
        ->and($category->slug)->toBe('technology')
        ->and($category->is_active)->toBeTrue();
});

it('can create a category with custom attributes', function () {
    $manager = new CategoryManager;

    $category = $manager->createCategory([
        'name' => 'Custom Category',
        'slug' => 'custom-slug',
        'description' => 'Custom description',
        'is_active' => false,
        'order' => 5,
        'type' => 'custom',
        'meta' => ['key' => 'value'],
    ]);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->slug)->toBe('custom-slug')
        ->and($category->is_active)->toBeFalse()
        ->and($category->order)->toBe(5)
        ->and($category->type)->toBe('custom')
        ->and($category->meta)->toBe(['key' => 'value']);
});

it('can reorder categories', function () {
    $manager = new CategoryManager;

    // Create parent category
    $parent = Category::create(['name' => 'Parent', 'slug' => 'parent']);

    // Create some child categories
    $child1 = Category::create([
        'name' => 'Child 1',
        'slug' => 'child-1',
        'parent_id' => $parent->id,
        'order' => 1,
    ]);

    $child2 = Category::create([
        'name' => 'Child 2',
        'slug' => 'child-2',
        'parent_id' => $parent->id,
        'order' => 2,
    ]);

    $child3 = Category::create([
        'name' => 'Child 3',
        'slug' => 'child-3',
        'parent_id' => $parent->id,
        'order' => 3,
    ]);

    // Move Child 3 to position 2
    $manager->reorderCategory($child3->id, null, 2);

    // Refresh models from database
    $child1->refresh();
    $child2->refresh();
    $child3->refresh();

    // Check new order
    expect($child1->order)->toBe(1)
        ->and($child3->order)->toBe(2)
        ->and($child2->order)->toBe(3);
});

it('can change parent and order simultaneously', function () {
    $manager = new CategoryManager;

    // Create two parent categories
    $parent1 = Category::create(['name' => 'Parent 1', 'slug' => 'parent-1']);
    $parent2 = Category::create(['name' => 'Parent 2', 'slug' => 'parent-2']);

    // Create child under parent 1
    $child = Category::create([
        'name' => 'Child',
        'slug' => 'child',
        'parent_id' => $parent1->id,
        'order' => 1,
    ]);

    // Create existing child under parent 2
    $existingChild = Category::create([
        'name' => 'Existing Child',
        'slug' => 'existing-child',
        'parent_id' => $parent2->id,
        'order' => 1,
    ]);

    // Move child to parent 2 and set order
    $manager->reorderCategory($child->id, $parent2->id, 1);

    // Refresh models
    $child->refresh();
    $existingChild->refresh();

    // Check new parent and order
    expect($child->parent_id)->toBe($parent2->id)
        ->and($child->order)->toBe(1)
        ->and($existingChild->order)->toBe(2);
});
