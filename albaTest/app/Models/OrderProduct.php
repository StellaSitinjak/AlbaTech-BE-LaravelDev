<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'orderproducts';

    protected $fillable = [
        'orders_id',
        'product_id',
        'amount',
    ];

    public function orders() {
        return $this->belongsTo('App\Models\Orders');
    }

    public function products() {
        return $this->belongsTo('App\Models\Products');
    }
}
