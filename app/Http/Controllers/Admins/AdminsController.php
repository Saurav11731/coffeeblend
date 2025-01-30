<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Booking;
use App\Models\Product\Order;
use App\Models\Product\Product as ProductProduct;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    public function viewLogin()
    {
        return view('admins.login');
    }
    public function checkLogin(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            
            return redirect()->route('admin.dashboard');

        }
        return redirect()->back()->with(['error' => 'error logging in']);
        
    }
    public function index()
    {
        $productsCount = Product::select()->count();
        $ordersCount = Order::select()->count();
        $bookingsCount = Booking::select()->count();
        $adminsCount = Admin::select()->count();
        return view('admins.index' , compact('productsCount', 'ordersCount', 'bookingsCount', 'adminsCount'));
    }
    public function displayAllAdmins()
    {
        $allAdmins = Admin::select()->orderBy('id', 'desc')->get();
        return view('admins.alladmins', compact('allAdmins'));
    }
    public function createAdmins()
    {
       
        return view('admins.createadmins');
    }
    public function storeAdmins(Request $request)
    {
        $storeAdmins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash:: make($request->password),
        ]);
        if($storeAdmins){
            return redirect()->route('all.admins')->with(['success' => 'Admin created successfully']);
        }
        // else{
        //     return redirect()->back()->with(['error' => 'error creating admin']);
        // }
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|unique:admins,email',
        //     'password' => 'required|min:6',
        //     'password_confirmation' => 'required|same:password',
        // ]);
        // $admin = Admin::create([
        //     'name' => $request->input('name'),
        //     'email' => $request->input('email'),
        //     'password' => bcrypt($request->input('password')),
        // ]);
    
}
}
