<?php

namespace Ihossain\CategoryManager\Tests\Models;

use Ihossain\CategoryManager\Traits\HasCategories;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasCategories;

    protected $guarded = [];

    protected $table = 'products';
}
