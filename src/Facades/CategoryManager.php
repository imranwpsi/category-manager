<?php

namespace Imranwpsi\CategoryManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Imranwpsi\CategoryManager\CategoryManager
 */
class CategoryManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Imranwpsi\CategoryManager\CategoryManager::class;
    }
}
