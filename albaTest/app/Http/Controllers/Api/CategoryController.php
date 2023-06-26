<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return new ResponseResource(true, 'List Data Category', $category);
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
            'name'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $category = Category::create([
                'name'   => $request->name,
            ]);
    
            $category = Category::find($category->id);
            return new ResponseResource(true, 'Data Category Berhasil Ditambahkan!', $category);
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $category = Category::find($id);
            if(!$category) {
                return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
            } else {
                return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
            }
            return new ResponseResource(true, 'Detail Data Category', $category);
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
            'name'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
            
        $position = User::find(Auth::id());
        if (Auth::check() && $position->position != 'Customer') {
            $category = Category::find($id);
            if(!$category) {
                return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
            }

            $category->update([ 'name'  => $request->name ]);
    
            $category = Category::find($id);
            return new ResponseResource(true, 'Data Category Berhasil Diubah!', $category);
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
            $category = Category::find($id);
            if(!$category) {
                return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
            }

            $product = ProductCategory::where('category_id', $id)->first();
            if($product) {
                return response()->json(new ResponseResource(false, "Terdapat product pada category!", null), 422);
            } else {
                $category->delete();
                return new ResponseResource(true, 'Data Category Berhasil Dihapus!', null);
            }
        }
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }
}
