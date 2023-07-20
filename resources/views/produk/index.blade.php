@extends('layout.app')

@section('title', 'Data Barang')

@section('content')

<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">
            Data Barang
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
                        <th>Kategori</th>
                        <th>Subkategori</th>
                        <th>Nama barang</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Bahan</th>
                        <th>Sku</th>
                        <th>Ukuran</th>
                        <th>Warna</th>
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
                        <label for="">Kategori</label>
                        <select name="category_id" id="category_id" class="form-control">
                           @foreach ($categories as $category)
                             <option value="{{$category->id}}">{{$category->nama_kategory}}</option>
                           @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Subkategori</label>
                        <select name="subcategory_id" id="subcategory_id" class="form-control">
                           @foreach ($subcategories as $subcategory)
                             <option value="{{$subcategory->id}}">{{$subcategory->nama_subcategory}}</option>
                           @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Nama Barang</label>
                        <input type="text" class="form-control" cols="30" rows="10" name="nama_barang" placeholder="Nama Barang">
                    </div>

                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea type="text" class="form-control" cols="30" rows="10" name="description" placeholder="Deskripsi"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="number" class="form-control" cols="30" rows="10" name="harga" placeholder="Harga">
                    </div>

                    <div class="form-group">
                        <label for="">Diskon</label>
                        <input type="number" class="form-control" cols="30" rows="10" name="diskon" placeholder="Diskon">
                    </div>

                    <div class="form-group">
                        <label for="">Bahan</label>
                        <input type="text" class="form-control" cols="30" rows="10" name="bahan" placeholder="Bahan">
                    </div>

                    <div class="form-group">
                        <label for="">Tags</label>
                        <input type="text" class="form-control" cols="30" rows="10" name="tags" placeholder="Tags">
                    </div>

                    <div class="form-group">
                        <label for="">SKU</label>
                        <input type="text" class="form-control" cols="30" rows="10" name="sku" placeholder="SKU">
                    </div>

                    <div class="form-group">
                        <label for="">Ukuran</label>
                        <input type="text" class="form-control" cols="30" rows="10" name="ukuran" placeholder="Ukuran">
                    </div>

                    <div class="form-group">
                        <label for="">Warna</label>
                        <input type="text" class="form-control" cols="30" rows="10" name="warna" placeholder="Warna">
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
                url : '/api/products',
                success : function ({data}) {

                    let row;

                    data.map((value,index) => {
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${value.category.nama_kategory}</td>
                            <td>${value.subcategory.nama_subcategory}</td>
                            <td>${value.nama_barang}</td>
                            <td>${value.harga}</td>
                            <td>${value.diskon}</td>
                            <td>${value.bahan}</td>
                            <td>${value.sku}</td>
                            <td>${value.ukuran}</td>
                            <td>${value.warna}</td>
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
                        url : '/api/products/' + id,
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
                $('select[name="category_id"]').val('')
                   $('select[name="subcategory_id"]').val('')
                   $('textarea[name="description"]').val('')
                   $('input[name="harga"]').val('')
                   $('input[name="nama_barang"]').val('')
                   $('input[name="diskon"]').val('')
                   $('input[name="bahan"]').val('')
                   $('input[name="tags"]').val('')
                   $('input[name="sku"]').val('')
                   $('input[name="ukuran"]').val('')
                   $('input[name="warna"]').val('')

                $('.form-kategori').submit(function (e) {
                    e.preventDefault()
                    const token = localStorage.getItem('token')
                    const formdata = new FormData(this);


                    $.ajax({
                        url : '/api/products',
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

               $.get('/api/products/' + id, function(payload){
                   $('select[name="category_id"]').val(payload.data[0].category.id)
                   $('select[name="subcategory_id"]').val(payload.data[0].subcategory.id)
                   $('textarea[name="description"]').val(payload.data[0].description)
                   $('input[name="harga"]').val(payload.data[0].harga)
                   $('input[name="nama_barang"]').val(payload.data[0].nama_barang)
                   $('input[name="diskon"]').val(payload.data[0].diskon)
                   $('input[name="bahan"]').val(payload.data[0].bahan)
                   $('input[name="tags"]').val(payload.data[0].tags)
                   $('input[name="sku"]').val(payload.data[0].sku)
                   $('input[name="ukuran"]').val(payload.data[0].ukuran)
                   $('input[name="warna"]').val(payload.data[0].warna)
                console.log(payload.data[0].category.nama_kategory);
                });


                $('.form-kategori').submit(function (e) {
                    e.preventDefault()
                    const token = localStorage.getItem('token')
                    const formdata = new FormData(this);

                    $.ajax({
                        url : `/api/products/${id}?_method=PUT`,
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
