<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\OrderProduct;

class OrderProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order1 = Orders::create([
            'user_id' => 3,
            'payment' => 'Tunai',
            'total' => 45000,
            'status' => 'Dibayar'
        ]);
        $order2 = Orders::create([
            'user_id' => 2,
            'payment' => 'BNI',
            'total' => 28000,
            'status' => 'Pending'
        ]);

        $order1->orderProd()->create([
            'product_id' => 1,
            'amount' => '2'
        ]);
        $order2->orderProd()->createMany([[
            'product_id' => 3,
            'amount' => '1'
        ],[
            'product_id' => 4,
            'amount' => '1'
        ]]);
    }
}
