<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Product\Cart;
use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{
    public function singleProduct($id)
    {
        $product = Product::find($id);
        $relatedProducts = Product::where('type', $product->type)->where('id','!=', $id)
        ->take('4')->orderBy('id', 'desc')->get();
        return view('products.productsingle', compact('product', 'relatedProducts'));
    
    }
    
public function addCart(Request $request , $id)
{
     if (Auth::check()){
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
    // echo "Item added to cart";
    // return view('products.productsingle', compact('product', 'relatedProducts'));
}
}
