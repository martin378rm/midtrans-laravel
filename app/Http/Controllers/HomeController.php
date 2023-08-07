<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\About;
use App\Models\Order;
use App\Models\Slider;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Testimoni;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        if (!Auth::guard('webmember')->user()) {
            return redirect('/login_member');
        }

        $raja_ongkir = config('rajaongkir.key');
        $response = Http::withHeaders([
            'key' => $raja_ongkir
        ])->get('https://api.rajaongkir.com/starter/province');

        $province = $response['rajaongkir']['results'];

        $cart = Cart::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->get();
        $cart_total = Cart::where('id_member', Auth::guard('webmember')->user()->id)->where('is_checkout', 0)->sum('total');
        return view('home.cart', compact('cart', 'province', 'cart_total'));
    }

    public function add_to_cart(Request $request)
    {

        Cart::create($request->all());
    }

    public function delete_from_cart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }


    public function checkout_order(Request $request)
    {
        $id = DB::table('orders')->insertGetId([
            'id_member' => $request->id_member,
            'invoice' => date('ymds'),
            'grand_total' => $request->grand_total,
            'status' => 'Baru',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        for ($i = 0; $i < count($request->id_produk); $i++) {
            DB::table('order_detail')->insert([
                'id_order' => $id,
                'id_produk' => $request->id_produk[$i],
                'jumlah' => $request->jumlah[$i],
                'size' => $request->size[$i],
                'color' => $request->color[$i],
                'total' => $request->total[$i],
                'created_at' => date('Y-m-d', time()),
                'updated_at' => date('Y-m-d', time())
            ]);
        }

        Cart::where('id_member', Auth::guard('webmember')->user()->id)->update([
            'is_checkout' => 1
        ]);
    }

    public function checkout()
    {

        $raja_ongkir = config('rajaongkir.key');
        $response = Http::withHeaders([
            'key' => $raja_ongkir
        ])->get('https://api.rajaongkir.com/starter/province');

        $province = $response['rajaongkir']['results'];

        $about = About::first();
        $orders = Order::where('id_member', Auth::guard('webmember')->user()->id)->first();
        return view('home.checkout', compact('about', 'orders', 'province'));
    }

    public function get_city($id)
    {
        $raja_ongkir = config('rajaongkir.key');
        $response = Http::withHeaders([
            'key' => $raja_ongkir
        ])->get('https://api.rajaongkir.com/starter/city?province=' . $id);

        $cities = $response['rajaongkir']['results'];
        return response()->json([
            'payload' => $cities
        ]);
    }

    public function get_ongkir($tujuan, $weight)
    {
        $raja_ongkir = config('rajaongkir.key');
        $response = Http::withHeaders([
            'key' => $raja_ongkir
        ])->post('https://api.rajaongkir.com/starter/cost', [
                    'origin' => '455',
                    'destination' => $tujuan,
                    'weight' => $weight,
                    'courier' => 'jne'
                ]);

        return $response['rajaongkir']['results']['0']['costs']['0']['cost'];
    }

    public function payment(Request $request)
    {

        Payment::create([
            'id_order' => $request->id_order,
            'jumlah' => $request->jumlah,
            'id_member' => Auth::guard('webmember')->user()->id,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => '',
            'detail_alamat' => $request->detail_alamat,
            'status' => 'MENUNGGU',
            'no_rekening' => $request->no_rekening,
            'nama' => $request->nama
        ]);

        return redirect('/orders');
    }

    public function orders()
    {
        $orders = $cart = Order::where('id_member', Auth::guard('webmember')->user()->id)->get();
        $payments = $cart = Payment::where('id_member', Auth::guard('webmember')->user()->id)->get();
        return view('home.orders', compact('orders', 'payments'));
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

    public function pesanan_selesai(Order $order)
    {
        $order->update([
            'status' => 'Selesai'
        ]);
        $order->save();
        return redirect('/orders');
    }
}