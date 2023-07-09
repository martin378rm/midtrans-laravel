<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
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
        $orders = Order::all();

        return response()->json([
            "data" => $orders
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
        //

        $validator = Validator::make($request->all(), [
            "id_member" => "required"
        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();
        $order = Order::create($input);


        for ($i = 0; $i < count($input['id_produk']); $i++) {
            # code...
            OrderDetail::create([
                'id_order' => $order['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'color' => $input['color'][$i],
                'total' => $input['total'][$i],
            ]);
        }

        return response()->json([
            "data" => $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
        $validator = Validator::make($request->all(), [
            "id_member" => "required"
        ]);


        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();
        $order->update($input);


        DB::table('order_detail')->where('id_order', $order['id'])->delete();


        for ($i = 0; $i < count($input['id_produk']); $i++) {
            # code...
            OrderDetail::create([
                'id_order' => $order['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'color' => $input['color'][$i],
                'total' => $input['total'][$i],
            ]);
        }

        return response()->json([
            "data" => $order
        ]);
    }

    public function ubah_status(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'status updated',
            'payload' => $order
        ]);
    }

    public function dikonfirmasi()
    {
        $order = Order::where('status', 'Dikonfirmasi')->get();

        return response()->json([
            'payload' => $order
        ]);
    }

    public function dikemas()
    {
        $order = Order::where('status', 'Dikemas')->get();

        return response()->json([
            'payload' => $order
        ]);
    }

    public function dikirim()
    {
        $order = Order::where('status', 'Dikirim')->get();

        return response()->json([
            'payload' => $order
        ]);
    }

    public function diterima()
    {
        $order = Order::where('status', 'Diterima')->get();

        return response()->json([
            'payload' => $order
        ]);
    }

    public function selesai()
    {
        $order = Order::where('status', 'Selesai')->get();

        return response()->json([
            'payload' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();

        return response()->json([
            'message' => 'deleted success'
        ]);
    }
}