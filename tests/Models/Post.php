<?php

namespace Ihossain\CategoryManager\Tests\Models;

use Ihossain\CategoryManager\Traits\HasCategories;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasCategories;

    protected $guarded = [];

    protected $table = 'posts';
}
