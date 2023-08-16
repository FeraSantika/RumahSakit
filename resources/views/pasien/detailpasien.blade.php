@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Detail Data Pasien</h3>
        <div class="content bg-white border border-light">
            <div class="m-3">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="kode" class="form-label-md-6"><b>Kode Pasien</b></label>
                    </div>
                    <div class="col-md-4">
                        <label for="NIK" class="form-label-md-6"> : <b>{{ $dtpasien->pasien_kode }}</b></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="NIK" class="form-label-md-6"><b>NIK Pasien</b></label>
                            </div>
                            <div class="col-md-4">
                                <label for="NIK" class="form-label-md-6"> : {{ $dtpasien->pasien_NIK }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nama" class="form-label-md-6"><b>Nama Pasien</b></label>
                            </div>
                            <div class="col-md-4">
                                <label for="nama" class="form-label-md-6"> : {{ $dtpasien->pasien_nama }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tempat" class="form-label-md-6"><b>Tempat lahir</b></label>
                            </div>
                            <div class="col-md-8">
                                <label for="tempat" class="form-label-md-6"> :
                                    {{ $dtpasien->pasien_tempat_lahir }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tgl" class="form-label-md-6"><b>Tanggal lahir</b></label>
                            </div>
                            <div class="col-md-4">
                                <label for="tgl" class="form-label-md-6"> :
                                    {{ $dtpasien->pasien_tgl_lahir ?? '' }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="gender" class="form-label-md-6"><b>Jenis Kelamin</b></label>
                            </div>
                            <div class="col-md-4">
                                <label for="gender" class="col-md-6 col-form-label-md-6 text-md-start"> :
                                    {{ $dtpasien->pasien_jenis_kelamin }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="alamat" class="form-label-md-6"><b>Alamat</b></label>
                            </div>
                            <div class="col-md-8">
                                <label for="alamat" class="col-md-6 col-form-label-md-6 text-md-start"> :
                                    {{ $dtpasien->pasien_alamat }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="agama" class="form-label-md-6"><b>Agama</b></label>
                            </div>
                            <div class="col-md-4">
                                <label for="agama" class="col-md-6 col-form-label-md-6 text-md-start"> :
                                    {{ $dtpasien->pasien_agama }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="perkawinan" class="form-label-md-6"><b>Status Perkawinan</b></label>
                            </div>
                            <div class="col-md-5">
                                <label for="status" class="col-md-6 col-form-label-md-6 text-md-start"> :
                                    {{ $dtpasien->pasien_status }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="pekerjaan" class="form-label-md-6"><b>Pekerjaan</b></label>
                            </div>
                            <div class="col-md-8">
                                <label for="pekerjaan" class="col-md-6 col-form-label-md-6 text-md-start"> :
                                    {{ $dtpasien->pasien_pekerjaan }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="kewarganegaraan" class="form-label-md-6"><b>Kewarganegaraan</b></label>
                            </div>
                            <div class="col-md-4">
                                <label for="kewarganegaraan" class="col-md-6 col-form-label-md-6 text-md-start">
                                    :
                                    {{ $dtpasien->pasien_kewarganegaraan }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
