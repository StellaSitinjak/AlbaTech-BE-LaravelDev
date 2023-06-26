<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $order = Orders::all();
            return new ResponseResource(true, 'List Data Order', $order);
        } else {
            $order = Orders::where('user_id', Auth::id())->get();
            return new ResponseResource(true, 'List Data Order', $order);
        }
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
            'payment'    => 'required',
            'product_id' => 'required',
            'status'     => 'required',
            'amount'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = User::find(Auth::id());
        if (Auth::check() || $position->position == 'Customer') {
            $product = Products::find($request->product_id)->value('price');
            $discount = Products::find($request->product_id)->value('discount');
            $price = $product - ($product * ($discount/100));
    
            $order = Orders::create([
                'user_id' => Auth::id(),
                'payment' => $request->payment,
                'total'   => $price,
                'status'  => $request->status,
            ]);
            
            OrderProduct::create([
                'orders_id'   => $order->id,
                'product_id' => $request->product_id,
                'amount'     => $request->amount,
            ]);
    
            $order = Orders::find($order->id);
            return new ResponseResource(true, 'Data Order Berhasil Ditambahkan!', $order);            
        }
        return response()->json(new ResponseResource(false, 'Akun Anda Tidak Dapat Membuat Order', null), 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check()) {
            $order = Orders::find($id);
            if(!$order || $order->user_id != Auth::id()) {
                return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
            } else {
                return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
            }
            return new ResponseResource(true, 'Detail Data Order', $order);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
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
            'payment' => 'required',
            'status'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order = Orders::find($id);
        if (Auth::check() && $order->user_id == Auth::id()) {            
            $order->update([
                'payment' => $request->payment,
                'status'  => $request->status,
            ]);
    
            $order = Orders::find($id);
            return new ResponseResource(true, 'Data Order Berhasil Diubah!', $order);            
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Orders::find($id);

        if(!$order) {
            return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
        }

        if (Auth::check() && $order->user_id == Auth::id()) {
            OrderProduct::where('orders_id', $id)->delete();
            $order->delete();
            return new ResponseResource(true, 'Data Order Berhasil Dihapus!', null);
        }        
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }
}