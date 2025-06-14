<?php

namespace Ihossain\CategoryManager\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Ihossain\CategoryManager\Traits\HasCategories;

class Post extends Model
{
    use HasCategories;

    protected $guarded = [];
    protected $table = 'posts';
}
