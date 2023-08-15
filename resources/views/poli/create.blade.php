@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Tambah Data User</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('poli.store') }}" method="POST" class="mb-3" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nama" class="form-label-md-6">Nama Poli</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <button class="btn btn-primary" type="submit">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
