@extends('layout.app')

@section('title', 'Data Pesanan Dikonfirmasi')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data Pesanan Dikonfirmasi
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal Pesanan</th>
                        <th>Invoice</th>
                        <th>Member</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection


@push('js')
    <script>
        $(function () {

            const formatRupiah = (num) => {
                let rupiahFormat = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    }).format(num);

                return rupiahFormat;
            }

            const dateFormat = (input) => {
                let date = new Date(input)
                let day = date.getDate();
                let month = date.getMonth();
                let year = date.getFullYear();
                let hours = date.getHours();
                let minutes = date.getMinutes();
                return `${day}-${month}-${year} / ${hours}:${minutes}`
            }


            const token = localStorage.getItem('token')
            $.ajax({
                url : '/api/order/dikonfirmasi',
                headers : {
                            'Authorization' :  token
                        },
                success : function ({data}) {

                    let row;

                    data.map((value,index) => {
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${dateFormat(value.created_at)}</td>
                            <td>${value.invoice}</td>
                            <td>${value.member.nama_member}</td>
                            <td>${formatRupiah(value.grand_total)}</td>
                            <td>
                                <a  href="#" data-id="${value.id}" class="btn btn-success btn-aksi">Kemas</a>
                            </td>
                        </tr>
                        `
                    })

                    $('tbody').append(row)
                }
            });

            $(document).on('click','.btn-aksi',function() {
                const id = $(this).data('id');

                $.ajax({
                    url : '/api/order/ubah_status/' + id,
                    type : 'POST',
                    data : {
                        status : 'Dikemas'
                    },
                    headers : {
                        'Authorization' : token
                    },
                    success : function(data) {
                        location.reload()
                    }
                })
            })
        })
    </script>
@endpush
