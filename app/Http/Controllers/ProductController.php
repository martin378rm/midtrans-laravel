<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $product = Product::with('category', 'subcategory')->get();

        return response()->json([
            "success" => true,
            "data" => $product
        ]);
    }

    public function list()
    {

        $categories = Category::all();
        $subcategories = Subcategory::all();
        // $this->middleware('auth');
        return view('produk.index', compact('categories', 'subcategories'));
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
        // validasi

        $validator = Validator::make($request->all(), [
            "category_id" => "required",
            "subcategory_id" => "required",
            "nama_barang" => "required",
            "harga" => "required",
            "diskon" => "required",
            "bahan" => "required",
            "tags" => "required",
            "sku" => "required",
            "ukuran" => "required",
            "warna" => "required",
            "description" => "required",
            "image" => "required|image|mimes:svg,jpeg,png,jpg,gif|max:2048"
        ]);

        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        if ($request->has('image')) {
            $gambar = $request->file('image');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $namaGambar);
            $input['image'] = $namaGambar;
        }

        $product = Product::create($input);

        return response()->json([
            "success" => true,
            "data" => $product
        ]);
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show($id)
    {
        //
        $product = Product::where('id', $id)->with('category', 'subcategory')->get();
        return response()->json([
            "success" => true,
            'data' => $product
        ]);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Product $product)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // karena form tidak mengenali method (PUT) harus menggunakan http method spoofing

        $validator = Validator::make($request->all(), [
            "category_id" => "required",
            "subcategory_id" => "required",
            "nama_barang" => "required",
            "harga" => "required",
            "diskon" => "required",
            "bahan" => "required",
            "tags" => "required",
            "sku" => "required",
            "ukuran" => "required",
            "warna" => "required",
            "description" => "required"
            // "image" => "required|image|mimes:svg,jpeg,png,jpg,gif|max:2048"

        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        if ($request->has('image')) {
            File::delete('uploads/' . '.' . $product->image);
            $gambar = $request->file('image');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $namaGambar);
            $input['image'] = $namaGambar;
        }

        $product->update($input);

        return response()->json([
            "success" => true,
            'message' => 'update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        // dd($product->image);
        File::delete('uploads/' . $product->image);
        $product->delete();

        return response()->json([
            "success" => true,
            'message' => "deleted success"
        ]);
    }
}