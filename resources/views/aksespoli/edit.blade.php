@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Akses Poli</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('akses-poli.update', $dtaksespoli->id_akses_poli ?? '') }}" method="POST"
                    class="mb-3">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="user" class="col-md-2 col-form-label text-md-start">Username</label>
                        <div class="col-md-10 {{ $errors->has('user') ? 'has-error' : '' }}">
                            <select name="user" id="user" class="form-select">
                                @foreach ($dtuser as $user)
                                    <option value="{{ $user->User_id }}">{{ $user->User_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="poli" class="col-md-2 col-form-label text-md-start">Poli</label>
                        <div class="col-md-10 {{ $errors->has('poli') ? 'has-error' : '' }}">
                            <select name="poli" id="poli" class="form-select">
                                @foreach ($dtpoli as $poli)
                                    <option value="{{ $poli->id_poli }}">{{ $poli->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
@endsection
