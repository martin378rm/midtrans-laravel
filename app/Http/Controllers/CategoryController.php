<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $category = Category::all();

        return response()->json([
            "data" => $category
        ]);
    }

    public function list()
    {
        // $this->middleware('auth');
        return view('kategori.index');
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
            "nama_kategory" => "required",
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

        $category = Category::create($input);

        return response()->json([
            "success" => true,
            "data" => $category
        ]);
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(Category $category)
    {
        return response()->json([
            'data' => $category
        ]);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Category $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // karena form tidak mengenali method (PUT) harus menggunakan http method spoofing

        $validator = Validator::make($request->all(), [
            "nama_kategory" => "required",
            "description" => "required",

        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        if ($request->has('image')) {
            File::delete('uploads/' . '.' . $category->image);
            $gambar = $request->file('image');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $namaGambar);
            $input['image'] = $namaGambar;
        }

        $category->update($input);

        return response()->json([
            "success" => true,
            'message' => 'update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        //
        // dd($category->image);
        File::delete('uploads/' . $category->image);
        $category->delete();

        return response()->json([
            "success" => true,
            'message' => "deleted success"
        ]);
    }
}