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
            <a href="/kategori/create" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
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


            $.ajax({
                url : '/api/categories',
                success : function ({data}) {

                    let row;

                    data.map((value,index) => {
                        console.log(value)
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${value.nama_kategory}</td>
                            <td>${value.description}</td>
                            <td>${value.image}</td>
                        </tr>
                        `
                    })

                    $('tbody').append(row)
                }
            })

        })
    </script>
@endpush
