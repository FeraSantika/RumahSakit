@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Poli</h3>
        <div class="content bg-white border">
            <div class="m-5">

                <form action="{{ route('rumah_sakit.update', $rumahsakit->id_rumahsakit) }}" method="POST" class="mb-3"
                    enctype="multipart/form-data" id="form-id" name="form-edit-poli">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nama" class="form-label-md-6">Nama Rumah Sakit</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ $rumahsakit->nama_rumahsakit }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="alamat" class="form-label-md-6">Alamat</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="alamat" id="alamat" class="form-control"
                                value="{{ $rumahsakit->alamat_rumahsakit }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="telp" class="form-label-md-6">Nomor telp</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="telp" id="telp" class="form-control"
                                value="{{ $rumahsakit->telp_rumahsakit }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="email" class="form-label-md-6">Email</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ $rumahsakit->email_rumahsakit }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="logo" class="col-md-2 col-form-label text-md-start">Logo</label>
                        <div class="col-md-10 d-flex align-items-center">
                            @if ($rumahsakit->logo_rumahsakit)
                                <img src="{{ asset($rumahsakit->logo_rumahsakit) }}" width="50px" class="mr-auto">
                            @endif
                            <input type="file" name="logo" id="logo" class="form-control ms-3">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
