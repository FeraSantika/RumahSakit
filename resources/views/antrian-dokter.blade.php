@extends('main')
@section('style')
    <style>
        .text-customcolor {
            color: #your_color_code;
        }
    </style>
@endsection
@section('content')
    @if (Auth::user()->isDokter() || Auth::user()->isAdmin())
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <form class="d-flex">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-light" id="dash-daterange">
                                        <span class="input-group-text bg-primary border-primary text-white">
                                            <i class="mdi mdi-calendar-range font-13"></i>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <h4 class="page-title"></h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-4">
                        <div class="card widget text-center">
                            <div class="card-body"
                                style="height: 100%; background-color: #14959a!important; border-color: #14959a!important; color: #ffffff!important;">
                                <div class="col-md-12" style="background-color: #1ab2b8">
                                    <h2>Nomor Antrian</h2>
                                </div>
                                <div class="row mt-5"></div>
                                <div class="row mt-5"></div>
                                <h1 style="font-size: 70px;">
                                    {{ $antrian->poli->kode_poli ?? '' }} -
                                    {{ $antrian->nomor_antrian ?? '' }}
                                </h1>
                                <div class="row mb-5"></div>
                                <div class="row mb-5"></div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-xl-6 col-lg-4">
                        <div class="row mt-5"></div>
                        <div class="row mt-5"></div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card widget-flat bg-primary">
                                    <div class="card-body text-center">
                                        <form action="{{ route('antrian-update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_poli" value="{{ $idPoli }}">
                                            @if ($antrian && $antrian->antrian)
                                                <input type="hidden" name="nomor_antrian"
                                                    value="{{ $antrian->antrian->nomor_antrian }}">
                                            @else
                                                <input type="hidden" name="nomor_antrian" value="0">
                                            @endif
                                            <div class="btn-group">
                                                <button type="submit"
                                                    class="btn btn-primary btn-lg mb-2"><b>Next</b></button>
                                            </div>
                                        </form>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-sm-6">
                                <form action="{{ route('antrian-updatestatus') }}" method="POST">
                                    @csrf
                                    <div class="card widget-flat bg-success">
                                        <div class="card-body text-center">

                                            <input type="hidden" name="id_poli" value="{{ $idPoli }}">
                                            <div class="btn-group">
                                                <button type="submit"
                                                    class="btn btn-success btn-lg mb-2"><b>Panggil</b></button>
                                            </div>

                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </form>
                            </div> <!-- end col-->
                        </div>
                        <div class="row mb-5"></div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div>
            <!-- end row -->
        </div>
        <!-- end row -->
        </div>
        <!-- container -->
        </div>
    @endif
@endsection
@section('script')
    <script type="text/javascript"></script>
@endsection
