@extends('layout.app')

@section('title', 'Data Pembayaran')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data Pembayaran
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Order</th>
                        <th>Jumlah</th>
                        <th>Nomor Rekening</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- modal form tambah data --}}
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Form Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
                <form class="form-kategori" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="text" class="form-control" name="tanggal" placeholder="Tanggal" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="text" class="form-control" name="jumlah" placeholder="Deskripsi" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Nomor Rekening</label>
                        <input type="text" class="form-control" name="no_rekening" placeholder="Nomor Rekening" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="nama" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="DITERIMA">DITERIMA</option>
                            <option value="DITOLAK">DITOLAK</option>
                            <option value="MENUNGGU">MENUNGGU</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block ">submit</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
</div>

@endsection


@push('js')
    <script>
        $(function () {

            const dateFormat = (input) => {
                let date = new Date(input)
                let day = date.getDate();
                let month = date.getMonth();
                let year = date.getFullYear();
                return `${day}-${month}-${year}`
            }

            $.ajax({
                url : '/api/payments',
                success : function ({data}) {

                    let row;

                    data.map((value,index) => {
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${dateFormat(value.created_at)}</td>
                            <td>${value.id_order}</td>
                            <td>${value.jumlah}</td>
                            <td>${value.no_rekening}</td>
                            <td>${value.nama}</td>
                            <td>${value.status}</td>
                            <td>
                                <a data-toggle="modal" href="#modal-form" data-id="${value.id}" class="btn btn-warning modal-ubah">Edit</a>
                            </td>
                        </tr>
                        `
                    })

                    $('tbody').append(row)
                }
            });

            $(document).on('click','.btn-hapus',  function () {
                const id = $(this).data('id');
                const token = localStorage.getItem('token')


                confirm_dialog = confirm('Apakah anda yakin');
                if (confirm_dialog) {
                    $.ajax({
                        url : '/api/payments/' + id,
                        type : 'DELETE',
                        headers : {
                            'Authorization' :  token
                        },
                        success : function (data) {
                           if (data.message === 'deleted success'){
                            alert('deleted success')
                            location.reload()
                           }
                        }
                    })
                }
            });

            // todo edit status payment
            $(document).on('click', '.modal-ubah', function () {
               $('#modal-form').modal('show')
               const id = $(this).data('id')

               $.get('/api/payments/' + id, function({data}){
                   $('input[name="tanggal"]').val(dateFormat(data.created_at))
                   $('input[name="jumlah"]').val(data.jumlah)
                   $('input[name="no_rekening"]').val(data.no_rekening)
                   $('input[name="nama"]').val(data.nama)
                   $('input[name="status"]').val(data.status)
                });


                $('.form-kategori').submit(function (e) {
                    e.preventDefault()
                    const token = localStorage.getItem('token')
                    const formdata = new FormData(this);

                    $.ajax({
                        url : `/api/payments/${id}?_method=PUT`,
                        type : 'POST',
                        data :formdata,
                        cache : false,
                        contentType: false,
                        processData: false,
                        headers : {
                            'Authorization' : 'Bearer ' +  token
                        },
                        success : function(data) {
                            if (data.success) {
                                alert('update Successfully 🎈🎈');
                                location.reload();
                            }
                        }
                    })
                })
            });

        })
    </script>
@endpush
