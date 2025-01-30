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
use Illuminate\Support\Facades\File;

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
        request()->validate([
            'name' => 'required|max:40',
            'email' => 'required|max:40',
            'password' => 'required|max:40',
           
        ]);
        $storeAdmins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash:: make($request->password),
        ]);
        if($storeAdmins){
            return redirect()->route('all.admins')->with(['success' => 'Admin created successfully']);
        }
        else{
            return redirect()->back()->with(['error' => 'error creating admin']);
        }
        
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

    public function displayAllOrders()
    {
        $allOrders = Order::select()->orderBy('id', 'desc')->get();
        return view('admins.allorders', compact('allOrders'));
    }
    public function editOrders($id)
    {
        $order = Order::find($id);
        return view('admins.editorders', compact('order'));
    }
    public function updateOrders(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update($request->all());
        if($order){
            return redirect()->route('all.orders')->with(['update' => 'Order updated successfully']);
        }
        else{
            return redirect()->back()->with(['error' => 'error updating order']);
        }
        
    }
    public function deleteOrders($id)
    {
        $order = Order::find($id);
        $order->delete();
        if($order){
            return redirect()->route('all.orders')->with(['delete' => 'Order deleted successfully']);
        }
        else{
            return redirect()->back()->with(['error' => 'error deleting order']);
        }
    }
    public function displayProducts()    
    {
        $products = Product::select()->orderBy('id', 'desc')->get();
        return view('admins.allproducts', compact('products'));
    }
    public function createProducts(){
     
        return view('admins.createproducts');
    }
    public function storeProducts(Request $request)
    {
        // request()->validate([
        //     'name' => 'required|max:40',
        //     'price' => 'required|max:40',
        //     'description' => 'required|max:40',
        //     'image' => 'required|max:40',
        // ]);
        $destinationPath = 'assets/images/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);
        $storeProducts = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $myimage,
            'type' => $request->type,
        ]);
        if($storeProducts){
            return redirect()->route('all.products')->with(['success' => 'Product created successfully']);
        }
        else{
            return redirect()->back()->with(['error' => 'error creating product']);
         }
    }
    public function deleteProducts($id){
        $product = Product::find($id);
        if(File::exists(public_path('assets/images/' . $product->image))){
            File::delete(public_path('assets/images/' . $product->image));
        }else{
            //dd('File does not exists.');
        }
        $product->delete();
        if($product){
            return redirect()->route('all.products')->with(['delete' => 'Product deleted successfully']);
        }
        else{
            return redirect()->back()->with(['error' => 'error deleting product']);
        }
    }
    public function displayBookings()
    {
        $bookings = Booking::select()->orderBy('id', 'desc')->get();
        return view('admins.allbookings', compact('bookings'));
    }
    
    public function editBooking(){
        $booking = Booking::find(request()->id);
        return view('admins.editbooking', compact('booking'));
    }
    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->update($request->all());
        if($booking){
            return redirect()->route('all.bookings')->with(['update' => 'Booking updated successfully']);
        }
        else{
            return redirect()->back()->with(['error' => 'error updating booking']);
    }
    }
    public function deleteBooking($id){
        $booking = Booking::find($id);
        $booking->delete();
        if($booking){
            return redirect()->route('all.bookings')->with(['delete' => 'Booking deleted successfully']);
        }
        else{
            return redirect()->back()->with(['error' => 'error deleting booking']);
        }
    }
    
}
