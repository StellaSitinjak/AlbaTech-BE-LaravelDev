<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\ResponseResource;
use App\Models\User;
use App\Models\OrderProduct;
use App\Models\Orders;
use App\Models\Products;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderproduct = OrderProduct::all();
        return new ResponseResource(true, 'List Data Order-Product', $orderproduct);
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
        $validator = Validator::make($request->all(), [
            'orders_id' => 'required',
            'product_id' => 'required',
            'amount'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = User::find(Auth::id());
        $order = Orders::find($request->orders_id);
        if (Auth::check() && ($position->position != 'Customer' || $order->user_id == Auth::id())) {
            $product = Products::find($request->product_id)->value('price');
            $discount = Products::find($request->product_id)->value('discount');
    
            $price = $product - ($product * ($discount/100));
            $order->update(['total' => $order->total + $price]);
    
            $orderproduct = OrderProduct::create([
                'orders_id' => $request->orders_id,
                'product_id' => $request->product_id,
                'amount'   => $request->amount,
            ]);
    
            $orderproduct = OrderProduct::find($orderproduct->id);
            return new ResponseResource(true, 'Data Order-Product Berhasil Ditambahkan!', $orderproduct);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check()) {
            $orderproduct = OrderProduct::find($id);
            $order = Orders::find($id);
            if(!$orderproduct) {
                return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
            } elseif (Auth::id() != '1' && $order->user_id != Auth::id()) {
                return response()->json(new ResponseResource(false, 'Data Tidak Terdapat Pada Akun Anda', null), 404);
            }
            return new ResponseResource(true, 'Detail Data Order-Product', $orderproduct);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'amount'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orderproduct = OrderProduct::find($id);
        $order = Orders::find($orderproduct->orders_id);
        if (Auth::check() && (Auth::id() == '1' || $order->user_id == Auth::id())) {
            $product = Products::find($orderproduct->product_id)->value('price');
            $discount = Products::find($orderproduct->product_id)->value('discount');
    
            $price = $product - ($product * ($discount/100));
            $change = $request->amount - $orderproduct->amount;
    
            $order->update(['total' => $order->total + ($price * $change)]);
            $orderproduct->update([
                'amount'   => $request->amount,
            ]);
    
            $orderproduct = OrderProduct::find($orderproduct->id);
            return new ResponseResource(true, 'Data Order-Product Berhasil Diubah!', $orderproduct);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orderproduct = OrderProduct::find($id);
        $order = Orders::find($orderproduct->orders_id);

        if(!$orderproduct) {
            return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
        } elseif (Auth::id() != '1' && $order->user_id != Auth::id()) {
            return response()->json(new ResponseResource(false, 'Data Tidak Terdapat Pada Akun Anda', null), 404);
        }

        if (Auth::check() && (Auth::id() == '1' || $order->user_id == Auth::id())) {
            $product = Products::find($orderproduct->product_id)->value('price');
            $discount = Products::find($orderproduct->product_id)->value('discount');
    
            $price = $product - ($product * ($discount/100));
            $order->update(['total' => $order->total - ($price * $orderproduct->amount)]);
    
            $orderproduct->delete();
    
            // return route('/orderproduct');
            return new ResponseResource(true, 'Data Order-Product Berhasil Dihapus!', null);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }
}
