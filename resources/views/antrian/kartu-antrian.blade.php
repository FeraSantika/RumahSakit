<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from coderthemes.com/hyper_2/saas/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 04 Jul 2023 09:23:48 GMT -->

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('style')
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Frappe-gantt css -->
    <link href="{{ asset('assets/vendor/frappe-gantt/frappe-gantt.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- Vector Map css -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">

    <!-- Fullcalendar css -->
    <link href="{{ asset('assets/vendor/fullcalendar/main.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include jQuery UI library -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    {{-- <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui-min.css" rel="stylesheet">
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script> --}}

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/hyper-config.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}

    <style>
        .user-photo-frame {
            width: 100px;
            height: 100px;
            border: 2px solid #000;
            /* Ganti warna dan lebar bingkai sesuai kebutuhan */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-right: 20px;
            /* Tambahkan margin kanan sesuai preferensi Anda */
        }

        .user-photo-frame img {
            max-width: 100%;
            max-height: 100%;
        }

        #obatList td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="page-title-box">
                            <div class="page-title-right"></div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-6 col-lg-8 mt-5">
                        <div class="card text-center">
                            <div class="card-header"
                                style="height: 130px; background-color: #14959a!important; color: #ffffff!important;">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($rs->logo_rumahsakit) }}"
                                        class="rounded-circle avatar-lg img-thumbnail" alt="profile-image"
                                        width="15px">
                                    <div class="ms-3 text-center">
                                        <h2>{{ $rs->nama_rumahsakit }}</h2>
                                        <h4>{{ $rs->alamat_rumahsakit }}|| {{ $rs->telp_rumahsakit }}||
                                            {{ $rs->email_rumahsakit }}</h4>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-1"
                                style="height: 2px;
                                        background-color: black;
                                        width: 100%;">
                            <hr class="my-1">
                            <div class="card-body">
                                <h3>Poli : {{ $nama_poli ?? '' }}</h3>
                                <h4>Nomor Antrian</h4>
                                <h1>{{ $nomor_antrian ?? '' }}</h1>
                            </div>
                            <hr class="my-1"
                                style="height: 2px;
                                        background-color: black;
                                        width: 100%;">
                            <hr class="my-1">
                            <div class="card-footer"
                                style="height: 130px; background-color: #14959a!important; color: #ffffff!important;">
                                <h5 id="printDate" ></h5>
                                <p>Simpan kartu antrian dengan baik, harap antri dan tunggu dengan tenang <i
                                        class="ri-emotion-line"></i></p>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                    <!-- Messages-->
                    <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
    </div>
    <!-- content -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->
    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

    <!-- Daterangepicker js -->
    <script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Apex Charts js -->
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Select2 js  -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <!-- Code Highlight js -->
    <script src="{{ asset('assets/vendor/highlightjs/highlight.pack.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/js/hyper-syntax.js') }}"></script>

    <!-- Gantt js-->
    <script src="{{ asset('assets/vendor/frappe-gantt/frappe-gantt.min.js') }}"></script>

    <!-- Droject Gantt Demo js -->
    <script src="{{ asset('assets/js/pages/demo.project-gantt.js') }}"></script>

    <!-- Vector Map js -->
    <script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>

    <!-- Todo js -->
    <script src="{{ asset('assets/js/ui/component.todo.js') }}"></script>

    <!-- Dashboard App js -->
    <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>

    <!-- Include SweetAlert 2 from a CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.3/dist/apexcharts.min.js"></script>
    <script src="{{ asset('assets/js/hyper-config.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentDate = new Date();
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            var formattedDate = currentDate.toLocaleDateString('id-ID', options);
            document.getElementById("printDate").innerHTML = formattedDate;
        });
    </script>
</body>

<!-- Mirrored from coderthemes.com/hyper_2/saas/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 04 Jul 2023 09:24:38 GMT -->

</html>
