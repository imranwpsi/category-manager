<?php

namespace Ihossain\CategoryManager\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Ihossain\CategoryManager\Traits\HasCategories;

class Product extends Model
{
    use HasCategories;

    protected $guarded = [];
    protected $table = 'products';
}
