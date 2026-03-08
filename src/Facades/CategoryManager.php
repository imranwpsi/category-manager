<?php

namespace Ihossain\CategoryManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ihossain\CategoryManager\CategoryManager
 */
class CategoryManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ihossain\CategoryManager\CategoryManager::class;
    }
}
