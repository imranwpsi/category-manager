<?php

namespace Imranwpsi\CategoryManager\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Imranwpsi\CategoryManager\Traits\HasCategories;

class Product extends Model
{
    use HasCategories;

    protected $guarded = [];
    protected $table = 'products';
}