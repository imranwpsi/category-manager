<?php

namespace Ihossain\CategoryManager\Traits;

use Ihossain\CategoryManager\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

trait HasCategories
{
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function scopeWithCategories($query, array $categories): Builder
    {
        return $query->whereHas('categories', function ($q) use ($categories) {
            $q->whereIn('id', $categories);
        });
    }

    public function attachCategory($category): ?array
    {
        if (is_array($category) || $category instanceof Collection) {
            return $this->categories()->syncWithoutDetaching($category);
        }

        return $this->categories()->attach($category);
    }

    public function detachCategory($category): int
    {
        return $this->categories()->detach($category);
    }

    public function syncCategories($categories): array
    {
        return $this->categories()->sync($categories);
    }
}
