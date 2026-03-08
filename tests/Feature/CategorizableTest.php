<?php

use Ihossain\CategoryManager\Models\Category;
use Ihossain\CategoryManager\Tests\Models\Post;
use Ihossain\CategoryManager\Tests\Models\Product;

it('can categorize different models', function () {
    $post = Post::create(['title' => 'Post']);
    $product = Product::create(['name' => 'Product']);
    $category = Category::create(['name' => 'Shared', 'slug' => 'shared']);

    $post->attachCategory($category);
    $product->attachCategory($category);

    expect($post->categories->first()->id)->toBe($category->id);
    expect($product->categories->first()->id)->toBe($category->id);
});

it('can handle different category types', function () {
    $postCategory = Category::create(['name' => 'Post Cat', 'slug' => 'post-cat', 'type' => 'blog']);
    $productCategory = Category::create(['name' => 'Product Cat', 'slug' => 'product-cat', 'type' => 'product']);

    $post = Post::create(['title' => 'Post']);
    $product = Product::create(['name' => 'Product']);

    $post->attachCategory($postCategory);
    $product->attachCategory($productCategory);

    expect($post->categories->first()->type)->toBe('blog');
    expect($product->categories->first()->type)->toBe('product');
});
