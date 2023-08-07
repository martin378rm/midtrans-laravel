@php
function rupiah ($angka) {
$hasil = 'Rp ' . number_format($angka, 2, ",", ".");
return $hasil;
}
@endphp

@extends('layout.home')

@section('title', 'Orders')

@section('content')
<!-- Checkout -->
<section class="section-wrap checkout pb-70">
    <div class="container relative">
        <div class="row">

            <div class="ecommerce col-xs-12">

                <h2>My Payments</h2>
                <table class="table table-ordered table-hover table-striped">
                    <thead>
                       <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                       </tr>
                    </thead>

                    <tbody>
                        @foreach ($payments as $index => $payment)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$payment->created_at}}</td>
                            <td>{{rupiah($payment->jumlah)}}</td>
                            <td>{{$payment->status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                <h2>My Orders</h2>
                <table class="table table-ordered table-hover table-striped">
                    <thead>
                       <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                       </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $index => $order)

                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{rupiah($order->grand_total)}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                <form action="/pesanan_selesai/{{$order->id}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">SELESAI</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end checkout -->
@endsection



