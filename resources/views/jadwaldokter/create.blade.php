@extends('main')
@section('content')
    <style>
        .ui-autocomplete {
            z-index: 215000000 !important;
        }

        .white-input {
            background-color: white;
            color: white;
            border-color: white;
        }
    </style>
    <div class="container mt-3">
        <h3>Tambah Jadwal Dokter</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('jadwal-dokter.store') }}" method="POST" class="mb-3">
                    @csrf

                    <div class="form-group row mb-3">
                        <label for="dokter" class="col-md-2 col-form-label text-md-start">Nama Dokter</label>
                        <div class="col-md-10">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" class="typeahead form-control" name="search" id="search-dokter"
                                    placeholder="Cari Nama Dokter">
                                <button class="btn btn-primary btn-sm" type="button" id="add-dokter"><i
                                        class="uil-search-alt"></i></button>
                            </div>
                        </div>
                    </div>

                    <input type="text" id="user_id" name="user_id" class="white-input" hidden>

                    <div class="form-group row mb-3">
                        <label for="hari" class="col-md-2 col-form-label text-md-start">Hari</label>
                        <div class="col-md-10 {{ $errors->has('hari') ? 'has-error' : '' }}">
                            <select name="hari" id="hari" class="form-control">
                                <option value="">Pilih Hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jum'at">Jum'at</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="waktu" class="col-md-2 col-form-label text-md-start">Waktu</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-5 {{ $errors->has('mulai') ? 'has-error' : '' }}">
                                    <div class="input-group">
                                        <input type="time" name="mulai" id="mulai" class="form-control">
                                        <span class="input-group-text">-</span>
                                        <input type="time" name="selesai" id="selesai" class="form-control">
                                    </div>
                                </div>
                            </div>
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
@section('script')
    <script>
        $(document).ready(function() {
            var path = "{{ route('autocomplete_jadwal-dokter') }}";
            $("#search-dokter").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            var transformedData = $.map(data, function(item) {
                                return {
                                    label: item.value,
                                    value: item.value,
                                    id: item.id
                                };
                            });

                            response(transformedData);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search-dokter').val(ui.item.label);
                    console.log('User_id:', ui.item.id);
                    $('#user_id').val(ui.item.id);
                    return false;
                }
            });
        });
    </script>
@endsection
