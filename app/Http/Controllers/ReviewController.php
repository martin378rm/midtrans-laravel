<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
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
        $review = Review::all();

        return response()->json([
            "success" => true,
            "data" => $review
        ]);

    }

    public function list()
    {
        // $this->middleware('auth');
        return view('reviews.index');
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
            "id_member" => "required",
            "id_produk" => "required",
            "review" => "required",
            "rating" => "required"
        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }


        $review = Review::create($request->all());
        // dd($review);
        return response()->json([
            "success" => true,
            "data" => $review
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
        return response()->json([
            "success" => true,
            'data' => $review
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
        $validator = Validator::make($request->all(), [
            "id_member" => "required",
            "id_produk" => "required",
            "review" => "required",
            "rating" => "required"

        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }


        $review->update($request->all());

        return response()->json([
            "success" => true,
            'message' => 'update successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
        File::delete('uploads/' . $review->gambar);
        $review->delete();

        return response()->json([
            "success" => true,
            'message' => "deleted success"
        ]);
    }
}