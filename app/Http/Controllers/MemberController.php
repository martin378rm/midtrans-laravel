<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $members = Member::all();

        return response()->json([
            "data" => $members
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
            "nama_member" => "required",
            "provinsi" => "required",
            "kabupaten" => "required",
            "kecamatan" => "required",
            "detail_alamat" => "required",
            "no_hp" => "required",
            "email" => "required",
            "password" => "required",

        ]);

        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        $members = Member::create($input);

        return response()->json([
            "data" => $members
        ]);
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Category $members)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Category $members)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // karena form tidak mengenali method (PUT) harus menggunakan http method spoofing

        $validator = Validator::make($request->all(), [
            "nama_member" => "required",
            "provinsi" => "required",
            "kabupaten" => "required",
            "kecamatan" => "required",
            "detail_alamat" => "required",
            "no_hp" => "required",
            "email" => "required",
            "password" => "required",

        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();

        $members = Member::find($id);
        if ($members) {
            $members->update($input);

            return response()->json([
                'message' => 'update successfully'
            ]);
        }

        return response()->json([
            "message" => "data not found"
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $members = Member::find($id);

        if ($members) {
            $members->delete();

            return response()->json([
                "message" => "delete successfully"
            ]);
        } else {
            return response()->json([
                "message" => "data not found"
            ], 404);
        }
    }
}