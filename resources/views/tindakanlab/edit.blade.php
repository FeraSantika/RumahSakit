@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Tindakan Lab</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('tindakan-lab.update', $dttindakan->id_tindakan) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="lab" class="col-md-2 col-form-label text-md-start">Nama Lab</label>
                        <div class="col-md-10 {{ $errors->has('lab') ? 'has-error' : '' }}">
                            @foreach ($dttindakan->lab as $tindakan)
                                <select name="lab" id="lab" class="form-control"
                                    value="{{ $tindakan->nama_lab }}">
                            @endforeach
                            @foreach ($dtlab as $item)
                                <option value="{{ $item->id_lab }}">{{ $item->nama_lab }}</option>
                            @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="nama" class="col-md-2 col-form-label text-md-start">Nama Tindakan</label>
                        <div class="col-md-10 {{ $errors->has('nama') ? 'has-error' : '' }}">
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ $dttindakan->nama_tindakan }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="harga" class="col-md-2 col-form-label text-md-start">Harga</label>
                        <div class="col-md-10 {{ $errors->has('harga') ? 'has-error' : '' }}">
                            <input type="text" name="harga" id="harga" class="form-control"
                                value="{{ $dttindakan->harga_tindakan }}">
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
