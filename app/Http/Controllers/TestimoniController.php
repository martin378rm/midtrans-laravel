<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TestimoniController extends Controller
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
        $testimoni = Testimoni::all();

        return response()->json([
            "success" => true,
            "data" => $testimoni
        ]);

    }

    public function list()
    {
        // $this->middleware('auth');
        return view('testimoni.index');
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
        //
        $validator = Validator::make($request->all(), [
            "nama_testimoni" => "required",
            "deskripsi" => "required",
            "gambar" => "required|image|mimes:svg,jpeg,png,jpg,gif|max:2048"
        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $namaGambar);
            $input['gambar'] = $namaGambar;
        }

        $testimoni = Testimoni::create($input);
        // dd($testimoni);
        return response()->json([
            "success" => true,
            "data" => $testimoni
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimoni $testimoni)
    {
        //
        return response()->json([
            "success" => true,
            'data' => $testimoni
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimoni $testimoni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimoni $testimoni)
    {
        //
        $validator = Validator::make($request->all(), [
            "nama_testimoni" => "required",
            "deskripsi" => "required",

        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        if ($request->has('image')) {
            File::delete('uploads/' . '.' . $testimoni->gambar);
            $gambar = $request->file('image');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $namaGambar);
            $input['gambar'] = $namaGambar;
        }

        $testimoni->update($input);

        return response()->json([
            "success" => true,
            'message' => 'update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimoni $testimoni)
    {
        //
        File::delete('uploads/' . $testimoni->gambar);
        $testimoni->delete();

        return response()->json([
            "success" => true,
            'message' => "deleted success"
        ]);
    }
}