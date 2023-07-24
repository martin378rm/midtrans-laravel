@extends('layout.app')

@section('title', 'Laporan')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Laporan
        </h4>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <form action="">
                    <div class="form-group">
                        <label for="">Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control" value="{{request()->input('dari')}}">
                    </div>
                    <div class="form-group">
                        <label for="">Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control" value="{{request()->input('sampai')}}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        @if (request()->input('dari'))


        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah dibeli</th>
                        <th>Pendapatan</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>



@endsection


@push('js')
    <script>
        $(function () {

            const dari = '{{request()->input('dari')}}'
            const sampai = '{{request()->input('sampai')}}'

            const formatRupiah = (num) => {
                let rupiahFormat = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    }).format(num);

                return rupiahFormat;
            }


            const token = localStorage.getItem('token')
            $.ajax({
                headers : {
                    'Authorization' : 'Bearer ' +  token
                },
                url : `/api/reports?dari=${dari}&sampai=${sampai}`,
                success : function ({data}) {

                    let row;

                    data.map((value,index) => {
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${value.nama_barang}</td>
                            <td>${value.harga}</td>
                            <td>${value.jumlah_dibeli}</td>
                            <td>${formatRupiah(value.pendapatan)}</td>
                            <td>${value.total_qty}</td>

                        </tr>
                        `
                    })

                    $('tbody').append(row)
                }
            });

            // $(document).on('click','.btn-aksi',function() {
            //     const id = $(this).data('id');

            //     $.ajax({
            //         url : '/api/order/ubah_status/' + id,
            //         type : 'POST',
            //         data : {
            //             status : 'Dikonfirmasi'
            //         },
            //         headers : {
            //             'Authorization' : token
            //         },
            //         success : function(data) {
            //             location.reload()
            //         }
            //     })
            // })
        })
    </script>
@endpush
