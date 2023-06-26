<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\ResponseResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check() && Auth::id() == 1) {
            $user = User::all();
            return new ResponseResource(true, 'List Data Users', $user);
        } else {
            return response()->json(new ResponseResource(false, 'Data Hanya Dapat Dilihat Oleh Admin!', null), 401);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user) {
            return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
        }
 
        if (Auth::check() && (Auth::id() == $id || Auth::id() == 1)) {
            return new ResponseResource(true, 'Detail Data User', $user);
        }
        
        return response()->json(new ResponseResource(false, 'Data Hanya Dapat Dilihat Oleh Admin dan Pemilik Akun!', null), 401);
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
            'name'      => 'required',
            'password'  => 'required',
            'address'   => 'required',
            'phoneNum'  => 'max:13',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($id);

        if(!$user) {
            return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
        }

        if (Auth::check() && (Auth::id() == $id || Auth::id() == '1')) {
            $user->update([
                'name'      => $request->name,
                'password'  => Hash::make($request->password),
                'address'   => $request->address,
                'phoneNum'  => $request->phoneNum,
            ]);
    
            $user = User::find($id);
            return new ResponseResource(true, 'Data User Berhasil Diubah!', $user);
        }
        
        return response()->json(new ResponseResource(false, 'Bukan Pemilik Data!', null), 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json(new ResponseResource(false, 'Tidak Terdapat Data', null), 404);
        }

        $user->delete();

        return new ResponseResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
