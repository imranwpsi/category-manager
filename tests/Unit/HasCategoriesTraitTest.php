<?php

use Ihossain\CategoryManager\Tests\Models\Post;
use Ihossain\CategoryManager\Models\Category;

beforeEach(function () {
    $this->post = Post::create(['title' => 'Test Post']);
    $this->category = Category::create(['name' => 'Test', 'slug' => 'test']);
});

it('can attach categories to model', function () {
    $this->post->attachCategory($this->category);

    expect($this->post->categories)->toHaveCount(1);
    expect($this->post->categories->first()->name)->toBe('Test');
});

it('can sync categories', function () {
    $category2 = Category::create(['name' => 'Test 2', 'slug' => 'test-2']);

    $this->post->syncCategories([$this->category->id, $category2->id]);

    expect($this->post->categories)->toHaveCount(2);
});

it('can detach categories', function () {
    $this->post->attachCategory($this->category);
    $this->post->detachCategory($this->category);

    expect($this->post->fresh()->categories)->toHaveCount(0);
});

it('can scope by categories', function () {
    $post2 = Post::create(['title' => 'Post 2']);
    $this->post->attachCategory($this->category);

    $results = Post::withCategories([$this->category->id])->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->title)->toBe('Test Post');
});
