<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'home'
        ]);
    }

    public function home()
    {
        $data = DB::table('products')
                    ->join('productcategory', 'productcategory.product_id', '=', 'products.id')
                    ->join('category', 'productcategory.category_id', '=', 'category.id')
                    ->select('products.*', 'category.name as category')
                    ->get();
        return view('index',compact('data'));
    }

    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|string',
            'password'  => 'required',
            'address'   => 'required',
            'birthdate' => 'required',
            'gender'    => 'required|max:1',
            'phoneNum'  => 'required|max:13',
        ]);

        $data = User::where('email', $request->email)->first();
        if($data){
            return redirect('/register')->with('alert','Email telah digunakan sebelumnya!');
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'address'   => $request->address,
            'birthdate' => $request->birthdate,
            'gender'    => $request->gender,
            'phoneNum'  => $request->phoneNum,
        ]);

        return redirect('/login')->with('alert-success','Kamu berhasil mendaftar');
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email|string',
            'password'  => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            session(['name'=>$user->name]);
            $request->session()->regenerate();
            return redirect('/home');
        } else {
            return back()->with('alert','Account is not Valid!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('name');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('/home')
            ->withSuccess('You have logged out successfully!');
    }
}
