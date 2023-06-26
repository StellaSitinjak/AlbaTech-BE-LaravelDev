<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\ResponseResource;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'email'     => 'required|email|string',
            'password'  => 'required',
            'address'   => 'required',
            'birthdate' => 'required|date',
            'gender'    => 'required|max:1',
            'phoneNum'  => 'required|max:13',
            'position'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'address'   => $request->address,
            'birthdate' => $request->birthdate,
            'gender'    => $request->gender,
            'phoneNum'  => $request->phoneNum,
            'position'  => $request->position,
        ]);

        $user = User::find($user->id);
        return new ResponseResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email|string',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Auth::login($user);
            $hashedToken = $user->createToken('ApiToken')->plainTextToken;
            $token = PersonalAccessToken::findToken($hashedToken);
            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $hashedToken,
                    'type' => 'bearer',
                ]
            ]);
        }
        return response()->json(new ResponseResource(false, 'Email atau Password Salah!', null), 401);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return new ResponseResource(true, 'Berhasil Log Out.', null);
    }
}
