@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Tambah Data Kamar Inap</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('kamar_inap.store') }}" method="POST" class="mb-3" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nama" class="form-label-md-6">Nama Kamar</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nomor" class="form-label-md-6">Nomor Kamar</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nomor" id="nomor" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="harga" class="form-label-md-6">Harga Kamar</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="harga" id="harga" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
