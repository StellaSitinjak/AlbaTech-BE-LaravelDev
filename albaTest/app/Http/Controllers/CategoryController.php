<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return view('category.index',compact('data'));
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
        $request->validate(['name'   => 'required']);
        $category = Category::create(['name'   => $request->name]);
        return redirect('/category')->with('alert-success','Data Category Berhasil Ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('products')
                    ->join('productcategory', 'productcategory.product_id', '=', 'products.id')
                    ->join('category', 'productcategory.category_id', '=', 'category.id')
                    ->where('productcategory.category_id', '=', $id)
                    ->get();
        
        $category = Category::find($id)->value('name');
        return view('category.detail',compact(['data', 'category']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        $product = ProductCategory::where('category_id', $id)->first();
        if($product) {
            return redirect('/category')->with('alert','Terdapat product pada category!');
        } else {
            $category->delete();
            return redirect('/category')->with('alert-success','Data Category Berhasil Dihapus!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['name'  => 'required']);
            
        $category = Category::find($id);
        $category->update(['name'   => $request->name]);

        return redirect('/category')->with('alert-success','Data Category Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
