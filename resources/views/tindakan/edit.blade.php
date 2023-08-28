@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Tindakan</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('tindakan.update', $dttindakan->id_tindakan) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama tindakan</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{$dttindakan->nama_tindakan}}">
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" name="harga" id="harga" class="form-control" value="{{$dttindakan->harga_tindakan}}">
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
