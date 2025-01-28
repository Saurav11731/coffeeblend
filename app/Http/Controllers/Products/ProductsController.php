<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Cart;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product\Order;
use App\Models\Product\Booking;

class ProductsController extends Controller
{
    public function singleProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('menu')->with('error', 'Product not found.');
        }
        $relatedProducts = Product::where('type', $product->type)->where('id', '!=', $id)
            ->take('4')->orderBy('id', 'desc')->get();
            
        if(isset(Auth::user()->id)){

        //Checking for products in cart
        $checkingInCart = Cart::where('pro_id', $id)->where('user_id', Auth::user()->id)->count();

        return view('products.productsingle', compact('product', 'relatedProducts', 'checkingInCart'));
    }else{
        return redirect()->route('login')->with('message', 'Please log in to view product details.');
    }
    }

    public function addCart(Request $request, $id)
    {
        if (Auth::check()) {
            $addCart = Cart::create([
                'pro_id' => $request->pro_id,
                'name' => $request->name,
                'image' => $request->image,
                'price' => $request->price,
                'user_id' => Auth::user()->id,
            ]);
            return Redirect::route('product.single', $id)->with(['success' => 'Product added to cart successfully']);
        } else {
            return Redirect::route('login')->with(['error' => 'You need to log in to add products to the cart']);
        }
    }
    public function cart()
    {
        if (Auth::check()) {
        $cartProducts = Cart::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        $totalPrice = Cart::where('user_id', Auth::user()->id)->sum('price');
        return view('products.cart', compact('cartProducts', 'totalPrice'));
    } else { 
     return redirect()->route('login')->with('message', 'Please log in to view your cart.'); 
    }
    }
    public function deleteProductCart($id)
    {
        $deleteProductCart = Cart::where('pro_id', $id)->where('user_id', Auth::user()->id);
        $deleteProductCart->delete();
        if ($deleteProductCart) {
            return Redirect::route('cart')->with(['delete' => 'Product removed from cart successfully']);
        }
    }
    public function prepareCheckout(Request $request)
    {
        $value = $request->price;
        $price = session()->put('price', $value);
        $newPrice = session()->get($price);
        if ($newPrice > 0) {
            return Redirect::route('checkout');
        }

        return view('products.checkout', compact('cartProducts', 'totalPrice'));
    }
    public function checkout()
    {

        return view('products.checkout');
    }
    public function storeCheckout(Request $request)
    {
        $checkout = Order::create(
            $request->all()
        );
        if ($checkout) {
            return view('products.pay'); 
        // return Redirect::route('products.pay');
        }
    }
    public function payWithPaypal()
    {
            return view('products.pay'); 
          //return Redirect::route('products.pay');
    }
    public function success()
    {
        $deleteItems = Cart::where('user_id', Auth::user()->id);
        $deleteItems->delete();
        if ($deleteItems) {
            session()->forget('price');
            return view('products.success');
        }
        
    }
    public function BookTables(Request $request)
    {
        request()->validate([
            'first_name' => 'required|max:40',
            'last_name' => 'required|max:40',
            'date' => 'required',
            'time' => 'required',
            'phone' => 'required|max:40',
            'message' => 'required',
        ]);
        if($request->date > date('n/j/Y')) {
            
            $bookTables = Booking::create(
                $request->all()
            );
            if ($bookTables) {
                return Redirect::route('home')->with('booking','Booking successful');
           
            }
        }else{
                return Redirect::route('home')->with('date','Invalide data,Please select a valid date');
            }

        }
        public function menu()
    {
       $desserts = Product::select()->where("type","desserts")->orderBy('id','desc')->take(4)->get();
       $drinks = Product::select()->where("type","drinks")->orderBy('id','desc')->take(4)->get();
       
            return view('products.menu' , compact('desserts','drinks'));
        }
        
    }
       
    
    

