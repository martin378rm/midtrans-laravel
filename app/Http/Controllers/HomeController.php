<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\About;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $sliders = Slider::all();
        $categories = Category::all();
        $testimoni = Testimoni::all();
        $products = Product::skip(0)->take(8)->get();
        return view('home.index', compact('sliders', 'categories', 'testimoni', 'products'));
    }
    public function products($id_subcategory)
    {
        $products = Product::where('subcategory_id', $id_subcategory)->get();
        return view('home.products', compact('products'));
    }

    public function product($id)
    {
        $product = Product::find($id);
        $latestProduct = Product::orderByDesc('created_at')->offset(0)->limit(5)->get();
        return view('home.product', compact('product', 'latestProduct'));
    }

    public function cart()
    {
        $carts = Cart::where('id_member', Auth::guard('webmember')->user()->id)->get();

        return view('home.cart', compact('carts'));
    }

    public function add_to_cart(Request $request)
    {
        // dd($request);
        Cart::create($request->all());
    }

    public function delete_from_cart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }

    public function checkout()
    {
        return view('home.checkout');
    }

    public function orders()
    {
        return view('home.orders');
    }

    public function about()
    {
        $about = About::first();
        $testimoni = Testimoni::all();
        return view('home.about', compact('about', 'testimoni'));
    }

    public function contact()
    {
        $about = About::first();
        return view('home.contact', compact('about'));
    }

    public function faq()
    {
        return view('home.faq');
    }
}