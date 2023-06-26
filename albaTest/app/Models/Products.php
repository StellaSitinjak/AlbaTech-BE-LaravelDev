<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'discount',
        'photo',
    ];

    public function prodCategory() {
        return $this->hasMany('App\Models\ProductCategory');
    }

    public function ordProduct() {
        return $this->hasMany('App\Models\OrderProduct');
    }

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => asset('/public' . $image),
        );
    }
}
