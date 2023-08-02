<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    //


    public function buy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "total" => "required|int",
            "ticket_id" => "required",
            "bank" => "required|in:bca,bni"
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'invalid',
                    'data' => $validator->errors()
                ]
            );
        }

        $ticket = DB::table('tickets')
            ->where('id', $request->ticket_id)
            ->first();

        if (!$ticket) {
            return response()->json([
                'message' => 'ticket not found',
                'data' => [
                    'ticket_id' => 'ticket not in database'
                ]
            ], 422);
        }

        try {
            DB::beginTransaction();
            // code...

            $serverKey = config('midtrans.key');

            $orderId = Str::uuid()->toString();
            $grossAmount = $ticket->price * $request->total + 5000;

            $response = Http::withBasicAuth($serverKey, "")
                ->post("https://api.sandbox.midtrans.com/v2/charge", [
                    'payment_type' => 'bank_transfer',
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $grossAmount
                    ],
                    'bank_transfer' => [
                        'bank' => $request->bank
                    ],
                    'customer_details' => [
                        'email' => $request->email,
                        'first_name' => 'CUSTOMER',
                        'last_name' => $request->name,
                        'phone' => '6281 1234 1234'
                    ],
                ]);

            // response gagal
            if ($response->failed()) {
                return response()->json(['message' => 'failed to charge'], 500);
            }

            $result = $response->json();

            // response selain 201
            if ($result['status_code'] != '201') {
                return response()->json(['message' => $result['status_message']], 500);
            }

            // insert table transactions
            DB::table('transactions')->insert([
                'uuid' => $orderId,
                'booking_code' => Str::random(6),
                'name' => $request->name,
                'email' => $request->email,
                'ticket_id' => $ticket->id,
                'total_ticket' => $request->total,
                'total_amount' => $grossAmount,
                'status' => 'BOOKED',
                'created_at' => now()
            ]);

            DB::table('tickets')->where('id', $ticket->id)->update([
                'stock' => $ticket->stock - $request->total
            ]);

            DB::commit();

            return response()->json([
                'data' => [
                    'va' => $result['va_numbers'][0]['va_number']
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "error_message" => $e->getMessage()
            ], 500);
        }
    }
}