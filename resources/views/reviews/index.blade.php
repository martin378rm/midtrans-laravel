@extends('layout.app')

@section('title', 'Data Kategori')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data Kategori
        </h4>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah Data</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
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
          <h5 class="modal-title">Form Kategori</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
                <form class="form-kategori" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategory" placeholder="Nama Kategori">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea type="text" class="form-control" cols="30" rows="10" name="description" placeholder="Deskripsi"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar</label>
                        <input type="file" class="form-control" name="image" placeholder="Gambar">
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

            $.ajax({
                url : '/api/categories',
                success : function ({data}) {

                    let row;

                    data.map((value,index) => {
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${value.nama_kategory}</td>
                            <td>${value.description}</td>
                            <td><img src='/uploads/${value.image}' width="100" height="100"></td>
                            <td>
                                <a data-toggle="modal" href="#modal-form" data-id="${value.id}" class="btn btn-warning modal-ubah">Edit</a>
                                <a  href="#" data-id="${value.id}" class="btn btn-danger btn-hapus">Hapus</a>
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
                        url : '/api/categories/' + id,
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


            // todo create kategori
            $('.modal-tambah').click(function () {
                $('#modal-form').modal('show')
                $('input[name="nama_kategory"]').val('')
                $('textarea[name="description"]').val('')

                $('.form-kategori').submit(function (e) {
                    e.preventDefault()
                    const token = localStorage.getItem('token')
                    const formdata = new FormData(this);


                    $.ajax({
                        url : '/api/categories',
                        type : 'POST',
                        data :formdata,
                        cache : false,
                        contentType: false,
                        processData: false,
                        headers : {
                            'Authorization' :  token
                        },
                        success : function(data) {
                            if (data.success) {
                                alert('Successfully 🎈🎈');
                                location.reload();
                            }
                        }
                    })
                })
            });


            // todo edit kategori
            $(document).on('click', '.modal-ubah', function () {
               $('#modal-form').modal('show')
               const id = $(this).data('id')

               $.get('/api/categories/' + id, function({data}){
                   $('input[name="nama_kategory"]').val(data.nama_kategory)
                   $('textarea[name="description"]').val(data.description)
                });


                $('.form-kategori').submit(function (e) {
                    e.preventDefault()
                    const token = localStorage.getItem('token')
                    const formdata = new FormData(this);

                    $.ajax({
                        url : `/api/categories/${id}?_method=PUT`,
                        type : 'POST',
                        data :formdata,
                        cache : false,
                        contentType: false,
                        processData: false,
                        headers : {
                            'Authorization' :  token
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
