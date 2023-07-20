<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->only(['list', 'dikonfirmasi_list', 'dikemas_list', 'dikirim_list', 'diterima_list', 'selesai_list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy', 'ubah_status', 'baru', 'dikonfirmasi', 'dikemas', 'dikirim', 'diterima', 'selesai']);
    }
    /**
     * Display a listing of the resource.
     */

    public function list()
    {
        return view('pesanan.index');
    }
    public function index()
    {
        //
        $orders = Order::with('member')->get();

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
        return response()->json([
            'data' => $order
        ]);
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
            'data' => $order
        ]);
    }

    public function baru()
    {
        $order = Order::with('member')->where('status', 'Baru')->get();

        return response()->json([
            'data' => $order
        ]);
    }
    public function dikonfirmasi()
    {
        $order = Order::with('member')->where('status', 'Dikonfirmasi')->get();

        return response()->json([
            'data' => $order
        ]);
    }

    public function dikemas()
    {
        $order = Order::with('member')->where('status', 'Dikemas')->get();

        return response()->json([
            'data' => $order
        ]);
    }

    public function dikirim()
    {
        $order = Order::with('member')->where('status', 'Dikirim')->get();

        return response()->json([
            'data' => $order
        ]);
    }

    public function diterima()
    {
        $order = Order::with('member')->where('status', 'Diterima')->get();

        return response()->json([
            'data' => $order
        ]);
    }

    public function selesai()
    {
        $order = Order::with('member')->where('status', 'Selesai')->get();

        return response()->json([
            'data' => $order
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

    public function dikonfirmasi_list()
    {
        return view('pesanan.dikonfirmasi');
    }
    public function dikemas_list()
    {
        return view('pesanan.dikemas');
    }
    public function dikirim_list()
    {
        return view('pesanan.dikirim');
    }
    public function diterima_list()
    {
        return view('pesanan.diterima');
    }
    public function selesai_list()
    {
        return view('pesanan.selesai');
    }
}