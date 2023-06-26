<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ResponseResource;
use App\Models\ProductCategory;
use App\Models\Products;
use App\Models\Category;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Products::all();
        return new ResponseResource(true, 'List Data Products', $product);
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
            'name'        => 'required',
            'price'       => 'required',
            'discount'    => 'required',
            'photo'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $image->storeAs('/product', $image->hashName());
    
                $product = Products::create([
                    'name'     => $request->name,
                    'price'    => $request->price,
                    'discount' => $request->discount,
                    'photo'    => $image->hashName(),
                ]);
            } else {
                $product = Products::create([
                    'name'     => $request->name,
                    'price'    => $request->price,
                    'discount' => $request->discount,
                ]);
            }
    
            $category = Category::find($request->category_id);
            $price = $request->price - ($request->price * ($request->discount/100));
    
            $category->update(['total' => $category->total + $price]);
            ProductCategory::create([
                'category_id' => $request->category_id,
                'product_id' => $product->id,
            ]);
    
            $product = Products::find($product->id);
            return new ResponseResource(true, 'Data Product Berhasil Ditambahkan!', $product);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::find($id);
        if(!$product) {
            return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
        } else {
            return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
        }
        return new ResponseResource(true, 'Detail Data Product', $product);
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
            'name'        => 'required',
            'price'       => 'required',
            'discount'    => 'required',
            'photo'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $product = Products::find($id);
            $productCategory = ProductCategory::where('product_id', $id)->first();
            $category = Category::find($productCategory->category_id);
    
            $productPrice = $product->price - ($product->price * ($product->discount/100));
            $price = $request->price - ($request->price * ($request->discount/100));
            $total = ($category->total - $productPrice) + $price;
    
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $image->storeAs('/public/product', $image->hashName());
                Storage::delete('/public/product/'.basename($product->photo));
    
                $product->update([
                    'name'     => $request->name,
                    'price'    => $request->price,
                    'discount' => $request->discount,
                    'photo'    => $image->hashName(),
                ]);
            } else {
                $product->update([
                    'name'     => $request->name,
                    'price'    => $request->price,
                    'discount' => $request->discount,
                ]);
            }
            $category->update(['total' => $total]);
    
            $product = Products::find($id);
            return new ResponseResource(true, 'Data Product Berhasil Diubah!', $product);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $product = Products::find($id);
            if(!$product) {
                return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
            }

            $productCategory = ProductCategory::where('product_id', $id)->first();
            $category = Category::find($productCategory->category_id);
    
            $productPrice = $product->price;
            $discount = $product->discount;
            $price = $productPrice - ($productPrice * ($discount/100));
    
            $category->update(['total' => $category->total - $price]);
            $productCategory->delete();
            $product->delete();
    
            return new ResponseResource(true, 'Data Product Berhasil Dihapus!', null);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }
}