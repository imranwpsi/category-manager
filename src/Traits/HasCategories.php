<?php

namespace Imranwpsi\CategoryManager\Traits;

use Imranwpsi\CategoryManager\Models\Category;

trait HasCategories
{
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function scopeWithCategories($query, array $categories)
    {
        return $query->whereHas('categories', function($q) use ($categories) {
            $q->whereIn('id', $categories);
        });
    }

    public function attachCategory($category)
    {
        if (is_array($category) || $category instanceof Collection) {
            return $this->categories()->syncWithoutDetaching($category);
        }

        return $this->categories()->attach($category);
    }

    public function detachCategory($category)
    {
        return $this->categories()->detach($category);
    }

    public function syncCategories($categories)
    {
        return $this->categories()->sync($categories);
    }
}