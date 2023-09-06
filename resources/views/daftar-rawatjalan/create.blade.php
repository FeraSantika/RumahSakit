@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Pendaftaran Pasien</h3>
        <div class="content bg-white border border-light">
            <div class="m-3">
                <form action="{{ route('daftar.online.store') }}" method="POST" class="mb-3" id="pasien-form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="kode" class="form-label-md-6">Kode Pendaftaran</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ $pendaftaranCode }}" readonly>
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

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="search" class="form-label-md-6"> Detail Pasien</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input class="typeahead form-control" name="search" id="search" class="form-control"
                                    placeholder="NIK | Nama pasien">
                                <button class="btn btn-primary btn-sm" type="button" id="add">
                                    <i class="ri-check-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="text" name="pasien_id" id="pasien_id" class="form-control" hidden>
                            <div class="mb-3">
                                <label for="nama" class="form-label-md-6">Nama Pasien</label>
                                <input type="text" name="nama" id="nama" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label-md-6">NIK Pasien</label>
                                <input type="text" name="nik" id="nik" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-3">
                                <label for="tgl" class="form-label-md-6">Tanggal lahir</label>
                                <input type="date" name="tgl" id="tgl" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label-md-6">Jenis Kelamin Pasien</label>
                                <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="keluhan" class="form-label-md-6">Keluhan</label>
                        </div>
                        <div class="col-md-10">
                            <textarea name="keluhan" id="keluhan" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label-md-6">Status Pasien</label>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="umum"
                                                value="Umum" checked>
                                            <label class="form-check-label" for="umum">
                                                Umum
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="bpjs"
                                                value="BPJS">
                                            <label class="form-check-label" for="bpjs">
                                                BPJS
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

            <div class="row">
                <div class="mt-3 text-center">
                    <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                    <button class="btn btn-primary" id="submit" type="submit">Daftar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var path = "{{ route('autocomplete_pasien') }}";
            $("#search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search').val(ui.item.label);

                    $('#nama').val(ui.item.label);
                    $('#pasien_id').val(ui.item.value3);
                    $('#nik').val(ui.item.value);
                    $('#tgl').val(ui.item.label2);
                    $('#jenis_kelamin').val(ui.item.value2);

                    return false;
                }
            });
        });

        var simpan = "{{ route('daftar.online.store') }}";
        $('#submit').click(function(e) {
            e.preventDefault();
            let kodedaftar = $('#kode').val();
            let pasien_id = $('#pasien_id').val();
            let poli = $('#poli').val();
            let nama = $('#nama').val();
            let nik = $('#nik').val();
            let tgl = $('#tgl').val();
            let keluhan = $('#keluhan').val();
            let jenis_kelamin = $('#jenis_kelamin').val();
            let status = $("input[name='status']:checked").val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: simpan,
                type: "POST",
                cache: false,
                data: {
                    "kode": kodedaftar,
                    "pasien_id": pasien_id,
                    "poli": poli,
                    "nama": nama,
                    "nik": nik,
                    "tgl": tgl,
                    "keluhan": keluhan,
                    "status": status,
                    "jenis_kelamin": jenis_kelamin,
                    "_token": token
                },
                success: function(response) {
                    if (response.error) {
                        swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'poli sudah terdaftar. Mohon gunakan poli lain.',
                            showConfirmButton: true,
                        });
                    } else {
                        let newpasienCode = response.new_kode;
                        if (typeof newpasienCode !== 'undefined') {
                            $('#kode').val(newpasienCode);
                            $('#pasien_id').val();
                            $('#poli').val('');
                            $('#nama').val('');
                            $('#nik').val('');
                            $('#tgl').val('');
                            $('#keluhan').val('');
                            $('#status').val('');
                            $('#jenis_kelamin').val('');

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
                    console.log(response.data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
