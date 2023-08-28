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
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ $pasienCode }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="NIK" class="form-label">NIK Pasien</label>
                                <input type="text" name="NIK" id="NIK" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label-md-6">Nama Pasien</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="tempat" class="form-label-md-6">Tempat lahir</label>
                                <input type="text" name="tempat" id="tempat" class="form-control">
                            </div>
                            <div class="row mb-3">
                                <label for="tgl" class="form-label-md-6">Tanggal lahir</label>
                                <input type="date" name="tgl" id="tgl" class="form-control">
                            </div>
                            <div class="row mb-3">
                                <label class="form-label-md-6">Jenis Kelamin</label>
                                <div class="row mt-2">
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="laki"
                                                value="Laki-laki" checked>
                                            <label class="form-check-label" for="laki">
                                                Laki-laki
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="perempuan"
                                                value="Perempuan">
                                            <label class="form-check-label" for="perempuan">
                                                Perempuan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat" class="form-label-md-6">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label-md-6">Agama</label>
                                <div class="{{ $errors->has('agama') ? 'has-error' : '' }}">
                                    <select name="agama" class="form-select" id="agama">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen protestan">Kristen Protestan</option>
                                        <option value="Kristen katolik">Kristen katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Khonghucu">Khonghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="form-label-md-6">Status Perkawinan</label>
                                <div class="row mt-2">
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="perkawinan" id="belumkawin"
                                                value="Belum Kawin" checked>
                                            <label class="form-check-label" for="belumkawin">
                                                Belum Kawin
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="perkawinan"
                                                id="kawin" value="Kawin">
                                            <label class="form-check-label" for="kawin">
                                                Kawin
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label-md-6">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kewarganegaraan" class="form-label-md-6">Kewarganegaraan</label>
                                <div class="{{ $errors->has('kewarganegaraan') ? 'has-error' : '' }}">
                                    <select name="kewarganegaraan" id="kewarganegaraan" class="form-select">
                                        <option value="WNI">WNI</option>
                                        <option value="WNA">WNA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="window.history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Tambah</button>
                        </div>
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
            let gender = $("input[name='gender']:checked").val();
            let alamat = $('#alamat').val();
            let agama = $('#agama').val();
            let status = $("input[name='perkawinan']:checked").val();
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
                    "jenis_kelamin": gender,
                    "alamat": alamat,
                    "agama": agama,
                    "perkawinan": status,
                    "pekerjaan": pekerjaan,
                    "kewarganegaraan": kewarganegaraan,
                    "_token": token
                },
                success: function(response) {
                    console.log(NIK);
                    if (response.error) {
                        swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'NIK sudah terdaftar. Mohon gunakan NIK lain.',
                            showConfirmButton: true,
                        });
                    } else {
                        let newpasienCode = response.new_kode;
                        if (typeof newpasienCode !== 'undefined') {
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
                        } else {
                            swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'NIK sudah terdaftar. Mohon gunakan NIK lain.',
                                showConfirmButton: true,
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
