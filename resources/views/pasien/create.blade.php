@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Tambah Data Pasien</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('pasien.store') }}" method="POST" class="mb-3" id="pasien-form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="kode" class="form-label-md-6">Kode Pasien</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ $pasienCode }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="NIK" class="form-label-md-6">NIK Pasien</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="NIK" id="NIK" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nama" class="form-label-md-6">Nama Pasien</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="tempat" class="form-label-md-6">Tempat lahir</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="tempat" id="tempat" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="tgl" class="form-label-md-6">Tanggal lahir</label>
                        </div>
                        <div class="col-md-10">
                            <input type="date" name="tgl" id="tgl" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="gender" class="col-md-2 col-form-label text-md-start">Gender</label>
                        <div class="col-md-10 {{ $errors->has('gender') ? 'has-error' : '' }}">
                            <select name="gender" id="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-md-2">
                            <label for="alamat" class="col-md-2 col-form-label text-md-start">Alamat</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="alamat" id="alamat" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="agama" class="form-label-md-6">Agama</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="agama" id="agama" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="status" class="col-md-2 col-form-label text-md-start">Status Perkawinan</label>
                        <div class="col-md-10 {{ $errors->has('status') ? 'has-error' : '' }}">
                            <select name="perkawinan" class="form-control" id="perkawinan">
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="pekerjaan" class="col-md-2 col-form-label text-md-start">Pekerjaan</label>
                        <div class="col-md-10">
                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="kewarganegaraan" class="col-md-2 col-form-label text-md-start">Kewarganegaraan</label>
                        <div class="col-md-10 {{ $errors->has('kewarganegaraan') ? 'has-error' : '' }}">
                            <select name="kewarganegaraan" id="kewarganegaraan" class="form-control">
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 text-center">
                        <button class="btn btn-primary" id="submit" type="submit">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var simpan = "{{ route('pasien.store') }}";
        $('#submit').click(function(e) {
            e.preventDefault();
            let kodepasien = $('#kode').val();
            let NIK = $('#NIK').val();
            let nama = $('#nama').val();
            let tempat = $('#tempat').val();
            let tgl = $('#tgl').val();
            let gender = $('#gender').val();
            let alamat = $('#alamat').val();
            let agama = $('#agama').val();
            let status = $('#perkawinan').val();
            let pekerjaan = $('#pekerjaan').val();
            let kewarganegaraan = $('#kewarganegaraan').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: simpan,
                type: "POST",
                cache: false,
                data: {
                    "kode": kodepasien,
                    "NIK": NIK,
                    "nama": nama,
                    "tempat": tempat,
                    "tgl": tgl,
                    "gender": gender,
                    "alamat": alamat,
                    "agama": agama,
                    "perkawinan": status,
                    "pekerjaan": pekerjaan,
                    "kewarganegaraan": kewarganegaraan,
                    "_token": token
                },
                success: function(response) {
                    let newpasienCode = response.new_kode;
                    $('#kode').val(newpasienCode);
                    $('#NIK').val('');
                    $('#nama').val('');
                    $('#tempat').val('');
                    $('#tgl').val('');
                    $('#gender').val('');
                    $('#alamat').val('');
                    $('#agama').val('');
                    $('#perkawinan').val('');
                    $('#pekerjaan').val('');
                    $('#kewarganegaraan').val('');

                    swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: true,
                    });
                    console.log(response.data);
                    console.log(newpasienCode);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        });
    </script>
@endsection
