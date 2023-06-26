<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = ['name', 'total'];

    public function productCat() {
        return $this->hasMany('App\Models\ProductCategory');
    }
}
