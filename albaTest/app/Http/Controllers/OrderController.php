<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Products;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Orders::all();
        return view('order.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('products')
                    ->join('orderproducts', 'orderproducts.product_id', '=', 'products.id')
                    ->join('orders', 'orderproducts.orders_id', '=', 'orders.id')
                    ->where('orderproducts.orders_id', '=', $id)
                    ->get();
        
        $order = DB::table('orders')
                    ->join('users', 'users.id', '=', 'orders.user_id')
                    ->where('orders.id', '=', $id)
                    ->select('orders.*', 'users.name')
                    ->get();
        return view('order.detail',compact(['data', 'order']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Orders::find($id);
        OrderProduct::where('orders_id', $id)->delete();
        $order->delete();
        return redirect('/order')->with('alert-success','Data Order Berhasil Dihapus!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
