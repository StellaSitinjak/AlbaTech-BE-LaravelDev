<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'productcategory';

    protected $fillable = [
        'category_id',
        'product_id',
    ];

    public function prod_category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function product_cat() {
        return $this->belongsTo('App\Models\Products');
    }
}
