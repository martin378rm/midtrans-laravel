<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        //
        $sub_category = Subcategory::all();

        return response()->json([
            "data" => $sub_category
        ]);
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
            "nama_subcategory" => "required",
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

        $sub_category = Subcategory::create($input);

        return response()->json([
            "data" => $sub_category
        ]);
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(Subcategory $subcategory)
    {
        //
        return response()->json([
            'data' => $subcategory
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
    public function update(Request $request, Subcategory $sub_category)
    {
        // karena form tidak mengenali method (PUT) harus menggunakan http method spoofing

        $validator = Validator::make($request->all(), [
            "category_id" => "required",
            "nama_subcategory" => "required",
            "description" => "required",

        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        if ($request->has('image')) {
            File::delete('uploads/' . '.' . $sub_category->image);
            $gambar = $request->file('image');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $namaGambar);
            $input['image'] = $namaGambar;
        }

        $sub_category->update($input);

        return response()->json([
            'message' => 'update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $sub_category)
    {
        //
        // dd($category->image);
        File::delete('uploads/' . $sub_category->image);
        $sub_category->delete();

        return response()->json([
            'message' => "deleted success"
        ]);
    }
}