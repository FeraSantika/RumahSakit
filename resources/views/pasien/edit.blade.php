@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Pasien</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('pasien.update', $dtpasien->pasien_id) }}" method="POST" class="mb-3">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="NIK" class="form-label-md-6">NIK Pasien</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="NIK" id="NIK" class="form-control"
                                value="{{ $dtpasien->pasien_NIK }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nama" class="form-label-md-6">Nama Pasien</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ $dtpasien->pasien_nama }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="tempat" class="form-label-md-6">Tempat lahir</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="tempat" id="tempat" class="form-control"
                                value="{{ $dtpasien->pasien_tempat_lahir }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="tgl" class="form-label-md-6">Tanggal lahir</label>
                        </div>
                        <div class="col-md-10">
                            <input type="date" name="tgl" id="tgl" class="form-control"
                                value="{{ $dtpasien->pasien_tgl_lahir ?? '' }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="gender" class="col-md-2 col-form-label text-md-start">Gender</label>
                        <div class="col-md-10 {{ $errors->has('gender') ? 'has-error' : '' }}">
                            <select name="gender" id="gender" class="form-control">
                                <option value="Male" {{ $dtpasien->pasien_gender == 'Male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female" {{ $dtpasien->pasien_gender == 'Female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="alamat" class="col-md-2 col-form-label text-md-start">Alamat</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="alamat" id="alamat" class="form-control"
                                value="{{ $dtpasien->pasien_alamat }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="agama" class="form-label-md-6">Agama</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="agama" id="agama" class="form-control"
                                value="{{ $dtpasien->pasien_agama }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="status" class="col-md-2 col-form-label text-md-start">Status Perkawinan</label>
                        <div class="col-md-10 {{ $errors->has('status') ? 'has-error' : '' }}">
                            <select name="status" class="form-control">
                                <option value="Belum Kawin"
                                    {{ $dtpasien->pasien_status == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                </option>
                                <option value="Kawin" {{ $dtpasien->pasien_status == 'Kawin' ? 'selected' : '' }}>Kawin
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="pekerjaan" class="col-md-2 col-form-label text-md-start">Pekerjaan</label>
                        <div class="col-md-10">
                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"
                                value="{{ $dtpasien->pasien_pekerjaan }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="kewarganegaraan" class="col-md-2 col-form-label text-md-start">Kewarganegaraan</label>
                        <div class="col-md-10 {{ $errors->has('kewarganegaraan') ? 'has-error' : '' }}">
                            <select name="kewarganegaraan" id="kewarganegaraan" class="form-control">
                                <option value="WNI" {{ $dtpasien->pasien_kewarganegaraan == 'WNI' ? 'selected' : '' }}>
                                    WNI
                                </option>
                                <option value="WNA" {{ $dtpasien->pasien_kewarganegaraan == 'WNA' ? 'selected' : '' }}>
                                    WNA
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <button class="btn btn-primary" type="submit">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
