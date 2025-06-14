<?php

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

    expect(fn() => Category::create(['name' => 'Test', 'slug' => 'test']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});

it('can be ordered', function () {
    $cat1 = Category::create(['name' => 'First', 'slug' => 'first', 'order' => 2]);
    $cat2 = Category::create(['name' => 'Second', 'slug' => 'second', 'order' => 1]);

    $ordered = Category::orderBy('order')->get();

    expect($ordered->first()->name)->toBe('Second');
    expect($ordered->last()->name)->toBe('First');
});
