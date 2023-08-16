@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Pendaftaran Pasien</h3>
        <div class="content bg-white border border-light">
            <div class="m-3">
                <form action="{{ route('pasien.store') }}" method="POST" class="mb-3" id="pasien-form"
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
                        <label for="role" class="col-md-2 col-form-label text-md-start">Poli</label>
                        <div class="col-md-4 {{ $errors->has('role') ? 'has-error' : '' }}">
                            <select name="role" id="role" class="form-select">
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
                            <div class="mb-3">
                                <label for="nama" class="form-label-md-6">Nama Pasien</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label-md-6">NIK Pasien</label>
                                <input type="text" name="nik" id="nik" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mb-3">
                                <label for="tgl" class="form-label-md-6">Tanggal lahir</label>
                                <input type="date" name="tgl" id="tgl" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="jenis+kelamin" class="form-label-md-6">Jenis Kelamin Pasien</label>
                                <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="keluhan" class="form-label-md-6">Keluhan</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="keluhan" id="keluhan" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-success" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search').val(ui.item.label);
                    return false;
                }
            });
            // $("#add").on("click", function() {
            // });
        });
    </script>
@endsection
