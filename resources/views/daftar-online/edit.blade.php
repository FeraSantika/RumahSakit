@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Pasien</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('daftar.online.update', $dtpendaftaran->id_pendaftaran) }}" method="POST"
                    class="mb-3" id="pasien-form" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="kode" class="form-label-md-6">Kode Pendaftaran</label>
                        </div>
                        <div class="col-md-4">
                            <label for="kode" class="form-label-md-6">: {{$dtpendaftaran->kode_pendaftaran}}</label>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="poli" class="col-md-2 col-form-label text-md-start">Poli</label>
                        <div class="col-md-4 {{ $errors->has('poli') ? 'has-error' : '' }}">
                            <select name="poli" id="poli" class="form-select">
                                @foreach ($dtpoli as $poli)
                                    <option value="{{ $poli->id_poli }}">{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="text" name="pasien_id" id="pasien_id" class="form-control" hidden>
                            <div class="mb-3">
                                <label for="nama" class="form-label-md-6">Nama Pasien</label>
                                <label for="nama" class="form-label-md-6"> : {{$dtpendaftaran->pasien->pasien_nama}}</label>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label-md-6">NIK Pasien</label>
                                <label for="nik" class="form-label-md-6"> : {{$dtpendaftaran->pasien->pasien_NIK}}</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="tgl" class="form-label-md-6">Tanggal lahir</label>
                                <label for="tgl" class="form-label-md-6"> : {{$dtpendaftaran->pasien->pasien_tgl_lahir}}</label>
                            </div>
                            <div class="mb-3">
                                <label for="jenis+kelamin" class="form-label-md-6">Jenis Kelamin Pasien</label>
                                <label for="jenis+kelamin" class="form-label-md-6"> : {{$dtpendaftaran->pasien->pasien_jenis_kelamin}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="keluhan" class="form-label-md-6">Keluhan</label>
                        </div>
                        <div class="col-md-10">
                            <textarea name="keluhan" id="keluhan" class="form-control" value="">{{$dtpendaftaran->keluhan}}</textarea>
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
