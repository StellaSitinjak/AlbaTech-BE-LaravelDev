<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('products')
                    ->join('productcategory', 'productcategory.product_id', '=', 'products.id')
                    ->join('category', 'productcategory.category_id', '=', 'category.id')
                    ->select('products.*', 'category.name as category')
                    ->get();
        return view('product.index',compact('data'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Products::find($id);
        $productCategory = ProductCategory::where('product_id', $id)->first();
        $category = Category::find($productCategory->category_id);
        
        $productPrice = $product->price;
        $discount = $product->discount;
        $price = $productPrice - ($productPrice * ($discount/100));
        
        $category->update(['total' => $category->total - $price]);
        $productCategory->delete();
        $product->delete();
        
        return redirect('/order')->with('alert-success','Data Product Berhasil Dihapus!');
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
