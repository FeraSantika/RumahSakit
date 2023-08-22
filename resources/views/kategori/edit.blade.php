@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Kategori Obat</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('kategori.update', $dtkategori->kode_kategori) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ $dtkategori->nama_kategori }}">
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
