<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list()
    {
        $sliders = Slider::all();
        return view('slider.index', compact('sliders'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $slider = Slider::all();

        return response()->json([
            "success" => true,
            "data" => $slider
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
            "nama_slider" => "required",
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

        $slider = Slider::create($input);

        return response()->json([
            'success' => true,
            'message' => 'succesfully',
            "data" => $slider
        ]);
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(Slider $slider)
    {
        //
        return response()->json([
            "success" => true,
            'data' => $slider
        ]);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Slider $slider)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        // karena form tidak mengenali method (PUT) harus menggunakan http method spoofing

        $validator = Validator::make($request->all(), [
            "nama_slider" => "required",
            "description" => "required",

        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        if ($request->has('image')) {
            File::delete('uploads/' . '.' . $slider->image);
            $gambar = $request->file('image');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $namaGambar);
            $input['image'] = $namaGambar;
        }

        $slider->update($input);

        return response()->json([
            'success' => true,
            'message' => 'update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        //
        // dd($slider->image);
        File::delete('uploads/' . $slider->image);
        $slider->delete();

        return response()->json([
            'success' => true,
            'message' => "deleted success"
        ]);
    }
}