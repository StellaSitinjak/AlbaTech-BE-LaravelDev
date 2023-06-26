<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductCategory;
use App\Http\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategory = ProductCategory::all();
        return new ResponseResource(true, 'List Data Product-Category', $productCategory);
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
            'category_id' => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $productCategory = ProductCategory::create([
                'category_id' => $request->category_id,
                'product_id' => $request->product_id,
            ]);
    
            $category = Category::find($request->category_id);
            $product = Products::find($request->product_id);
            $price = $product->price - ($product->price * ($product->discount/100));
            $category->update(['total' => $category->total + $price]);
    
            $productCategory = ProductCategory::find($productCategory->id);
            return new ResponseResource(true, 'Data Product-Category Berhasil Ditambahkan!', $productCategory);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productCategory = ProductCategory::find($id);
        if(!$productCategory) {
            return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
        } else {
            return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
        }
        return new ResponseResource(true, 'Detail Data Product-Category', $productCategory);
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
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $productCategory = ProductCategory::find($id);
            $product = Products::find($productCategory->product_id);
            $category = Category::find($productCategory->category_id);
            $categoryNew = Category::find($request->category_id);
    
            $price = $product->price - ($product->price * ($product->discount/100));
    
            $category->update(['total' => $category->total - $price]);
            $categoryNew->update(['total' => $categoryNew->total + $price]);
    
            $productCategory->update([
                'category_id' => $request->category_id,
            ]);
    
            $productCategory = ProductCategory::find($id);
            return new ResponseResource(true, 'Data Product-Category Berhasil Diubah!', $productCategory);
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
            $productCategory = ProductCategory::find($id);
            if(!$productCategory) {
                return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
            }
            
            if (ProductCategory::where('category_id', $productCategory->category_id)->count() <= 1) {
                return response()->json(new ResponseResource(false, 'Product Harus Memiliki Setidaknya 1 Category.', null), 422);
            }
    
            $product = Products::find($productCategory->product_id);
            $category = Category::find($productCategory->category_id);
    
            $productPrice = $product->price;
            $discount = $product->discount;
            $price = $productPrice - ($productPrice * ($discount/100));
    
            $category->update(['total' => $category->total - $price]);
            $productCategory->delete();
    
            return new ResponseResource(true, 'Data Product-Category Berhasil Dihapus!', null);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }
}