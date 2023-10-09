@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Akses Lab</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('akses-lab.update', $dtakseslab->id_akses_lab ?? '') }}" method="POST"
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
                        <label for="lab" class="col-md-2 col-form-label text-md-start">Lab</label>
                        <div class="col-md-10 {{ $errors->has('lab') ? 'has-error' : '' }}">
                            <select name="lab" id="lab" class="form-select">
                                @foreach ($dtlab as $lab)
                                    <option value="{{ $lab->id_lab }}">{{ $lab->nama_lab }}</option>
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
