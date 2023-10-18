@extends('layouts.app')

@section('content')
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center"
                            style="background-color: #14959a!important; color: #ffffff!important;">
                            <a href="index-2.html">
                                <img src="{{ asset($rs->logo_rumahsakit) }}" class="rounded-circle avatar-sm img-thumbnail"
                                    alt="logo" height="22">
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Cari Riwayat Rekam Medis Pasien</h4>
                                <p class="text-muted mb-4">Masukkan NIK dan tanggal lahir pasien untuk mengakses rekam medis
                                    pasien.
                                </p>
                            </div>

                            {{-- <form method="POST" action="{{ route('Login') }}">
                                @csrf --}}
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input class="form-control" name="nik" type="text" id="nik" required=""
                                    placeholder="NIK">
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Lahir</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" name="nik" type="date" id="nik" required=""
                                        placeholder="Tanggal lahir">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 mb-0 text-center">
                            <button class="btn btn-primary"
                                style="background-color: #14959a!important; color: #ffffff!important;" type="submit"> Log
                                In </button>
                        </div>

                        {{-- </form> --}}
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
    </div>
@endsection
