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

class ProductsController extends Controller
{
    public function singleProduct($id)
    {
        $product = Product::find($id);
        $relatedProducts = Product::where('type', $product->type)->where('id', '!=', $id)
            ->take('4')->orderBy('id', 'desc')->get();

        //Checking for products in cart
        $checkingInCart = Cart::where('pro_id', $id)->where('user_id', Auth::user()->id)->count();

        return view('products.productsingle', compact('product', 'relatedProducts', 'checkingInCart'));
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
        echo "Welcome to paypal payment ";
        // return Redirect::route('product.single', $id)->with(['success' => 'Product added to cart successfully']); 
    }
}
