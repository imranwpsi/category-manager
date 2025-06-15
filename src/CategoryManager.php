<?php

namespace Ihossain\CategoryManager;

use Ihossain\CategoryManager\Models\Category;
use Illuminate\Support\Str;

class CategoryManager
{
    public function createCategory(array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $data['is_active'] ?? true;
        $data['order'] = $data['order'] ?? 0;
        $data['meta'] = $data['meta'] ?? [];

        return Category::create($data);
    }

    public function createProductCategory(array $data): Category
    {
        return $this->createCategory(array_merge($data, [
            'type' => 'product',
        ]));
    }

    public function createPostCategory(array $data): Category
    {
        return $this->createCategory(array_merge($data, [
            'type' => 'blog',
        ]));
    }

    public function reorderCategory(int $categoryId, ?int $parentId = null, ?int $order = null): Category
    {
        $category = Category::findOrFail($categoryId);

        if ($parentId !== null) {
            $category->parent_id = $parentId;
        }

        if ($order !== null) {
            // Reorder siblings
            Category::where('parent_id', $category->parent_id)
                ->where('id', '!=', $category->id)
                ->orderBy('order')
                ->get()
                ->each(function ($sibling, $index) use ($order) {
                    $newOrder = $index + 1;
                    if ($newOrder >= $order) {
                        $newOrder += 1;
                    }
                    $sibling->order = $newOrder;
                    $sibling->save();
                });

            $category->order = $order;
        }

        $category->save();

        return $category;
    }
}
