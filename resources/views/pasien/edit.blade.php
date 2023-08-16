@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Pasien</h3>
        <div class="content bg-white border">
            <div class="m-5">

                <form action="{{ route('pasien.update', $dtpasien->pasien_id) }}" method="POST" class="mb-3"
                    id="pasien-form" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="kode" class="form-label-md-6">Kode Pasien</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ $dtpasien->pasien_kode }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="NIK" class="form-label">NIK Pasien</label>
                                <input type="text" name="NIK" id="NIK" class="form-control"
                                    value="{{ $dtpasien->pasien_NIK }}">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label-md-6">Nama Pasien</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="{{ $dtpasien->pasien_nama }}">
                            </div>
                            <div class="mb-3">
                                <label for="tempat" class="form-label-md-6">Tempat lahir</label>
                                <input type="text" name="tempat" id="tempat" class="form-control"
                                    value="{{ $dtpasien->pasien_tempat_lahir }}">
                            </div>
                            <div class="row mb-3">
                                <label for="tgl" class="form-label-md-6">Tanggal lahir</label>
                                <input type="date" name="tgl" id="tgl" class="form-control"
                                    value="{{ $dtpasien->pasien_tgl_lahir ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label-md-6">Jenis Kelamin</label>
                                <div class="{{ $errors->has('gender') ? 'has-error' : '' }}">
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="Laki-laki"
                                            {{ $dtpasien->pasien_jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Perempuan"
                                            {{ $dtpasien->pasien_jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="form-label-md-6">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control"
                                    value="{{ $dtpasien->pasien_alamat }}">
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label-md-6">Agama</label>
                                <div class="{{ $errors->has('agama') ? 'has-error' : '' }}">
                                    <select name="agama" class="form-select" id="agama">
                                        <option value="Islam" {{ $dtpasien->pasien_agama == 'Islam' ? 'selected' : '' }}>
                                            Islam</option>
                                        <option value="Kristen protestan"
                                            {{ $dtpasien->pasien_agama == 'Kristen protestan' ? 'selected' : '' }}>Kristen
                                            Protestan</option>
                                        <option value="Kristen katolik"
                                            {{ $dtpasien->pasien_agama == 'Kristen katolik' ? 'selected' : '' }}>Kristen
                                            katolik</option>
                                        <option value="Hindu" {{ $dtpasien->pasien_agama == 'Hindu' ? 'selected' : '' }}>
                                            Hindu</option>
                                        <option value="Budha" {{ $dtpasien->pasien_agama == 'Budha' ? 'selected' : '' }}>
                                            Budha</option>
                                        <option value="Khonghucu"
                                            {{ $dtpasien->pasien_agama == 'Khonghucu' ? 'selected' : '' }}>Khonghucu
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="perkawinan" class="form-label-md-6">Status Perkawinan</label>
                                <div class="{{ $errors->has('perkawinan') ? 'has-error' : '' }}">
                                    <select name="perkawinan" class="form-select" id="perkawinan">
                                        <option value="Belum Kawin"
                                            {{ $dtpasien->pasien_status == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                        </option>
                                        <option value="Kawin"
                                            {{ $dtpasien->pasien_status == 'Kawin' ? 'selected' : '' }}>Kawin
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label-md-6">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"
                                    value="{{ $dtpasien->pasien_pekerjaan }}">
                            </div>
                            <div class="mb-3">
                                <label for="kewarganegaraan" class="form-label-md-6">Kewarganegaraan</label>
                                <div class="{{ $errors->has('kewarganegaraan') ? 'has-error' : '' }}">
                                    <select name="kewarganegaraan" id="kewarganegaraan" class="form-select">
                                        <option value="WNI"
                                            {{ $dtpasien->pasien_kewarganegaraan == 'WNI' ? 'selected' : '' }}>
                                            WNI
                                        </option>
                                        <option value="WNA"
                                            {{ $dtpasien->pasien_kewarganegaraan == 'WNA' ? 'selected' : '' }}>
                                            WNA
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-success" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
