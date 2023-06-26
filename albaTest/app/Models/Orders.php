<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'payment',
        'total',
        'status',
    ];

    public function orderProd() {
        return $this->hasMany('App\Models\OrderProduct');
    }
}
