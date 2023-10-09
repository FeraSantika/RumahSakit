@extends('main')
@section('content')
    @if (Auth::user()->isAnalisLab() || Auth::user()->isAdmin())
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
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <h4 class="header-title">Pendaftaran Pasien</h4>
                                <div class="dropdown"></div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="chart-content-bg">
                                    <div class="row text-center">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <a href="{{ route('daftar-pasienjalan') }}">
                                                        <p class="text-muted mb-0 mt-3">Pasien Rawat Jalan</p>
                                                        <h2 class="fw-normal mb-3">
                                                            <small
                                                                class="mdi mdi-checkbox-blank-circle text-primary align-middle me-1"></small>
                                                            <span>{{ $pasienjalan }}</span>
                                                        </h2>
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <p class="text-start"><small
                                                            class="mdi mdi-checkbox-blank-circle text-info align-middle me-1"></small>Pasien
                                                        Umum : <b>{{ $pasienumum }}</b></p>
                                                    <p class="text-start"><small
                                                            class="mdi mdi-checkbox-blank-circle text-danger align-middle me-1"></small>Pasien
                                                        BPJS : <b>{{ $pasienbpjs }}</b></p>
                                                    <p class="text-start"><small
                                                            class="mdi mdi-checkbox-blank-circle text-warning align-middle me-1"></small>Pasien
                                                        Tertangani : <b>{{ $pasientertangani }}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <a href="{{ route('daftar.pasieninap') }}">
                                                        <p class="text-muted mb-0 mt-3">Pasien Rawat Inap</p>
                                                        <h2 class="fw-normal mb-3">
                                                            <small
                                                                class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                                            <span>{{ $pasieninap }}</span>
                                                        </h2>
                                                    </a>
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                    <p class="text-start"><small
                                                            class="mdi mdi-checkbox-blank-circle text-info align-middle me-1"></small>Pasien
                                                        Umum : <b>{{ $pasieninapumum }}</b></p>
                                                    <p class="text-start"><small
                                                            class="mdi mdi-checkbox-blank-circle text-danger align-middle me-1"></small>Pasien
                                                        BPJS : <b>{{ $pasieninapbpjs }}</b></p>
                                                    <p class="text-start"><small
                                                            class="mdi mdi-checkbox-blank-circle text-warning align-middle me-1"></small>Pasien
                                                        Tertangani : <b>{{ $pasieninaptertangani }}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div dir="ltr">
                                    <div id="chart" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
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
    <script type="text/javascript">
        var pasienjalan = @json($totalspasienjalan);
        var pasieninap = @json($totalspasieninap);

        var options = {
            series: [{
                name: "Pendaftaran Pasien Rawat Jalan",
                data: pasienjalan
            }, {
                name: "Pendaftaran Pasien Rawat Inap",
                data: pasieninap
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: @json($labels)
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection
