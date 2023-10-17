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
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">

                            </div>
                            {{-- <h4 class="page-title">Detail Pembayaran</h4> --}}
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-8 col-lg-10">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($rs->logo_rumahsakit) }}"
                                        class="rounded-circle avatar-lg img-thumbnail" alt="profile-image"
                                        width="25px">
                                    <div class="ms-3 text-center">
                                        <h2>{{ $rs->nama_rumahsakit }}</h2>
                                        <h6>{{ $rs->alamat_rumahsakit }}|| {{ $rs->telp_rumahsakit }}||
                                            {{ $rs->email_rumahsakit }}</h6>
                                        <hr class="my-1"
                                            style="height: 2px;
                                        background-color: black;
                                        width: 100%;">
                                        <hr class="my-1">
                                        <h5 class="page-title">Detail Pembayaran</h5>
                                        @foreach ($dtpendaftar as $pendaftar)
                                    </div>
                                </div>
                                <input type="text" name="kode" id="kode"
                                    value="{{ $pendaftar->kode_pendaftaran }}" hidden>

                                <div class="text-start mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table-custom">
                                                <tr>
                                                    <td><strong>NIK </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_NIK }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nama </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status Pasien </strong></td>
                                                    <td>
                                                        : {{ $pendaftar->status_pasien }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tempat lahir </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_tempat_lahir }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tanggal lahir </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_tgl_lahir }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Jenis kelamin </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_jenis_kelamin }}</td>
                                                </tr>
                                            </table>
                                        </div>


                                        <div class="col-md-6">
                                            <table class="table-custom">
                                                <tr>
                                                    <td><strong>Kewarganegaraan </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_kewarganegaraan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Alamat </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_alamat }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pekerjaan </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_pekerjaan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status Perkawinan </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_status }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Agama </strong></td>
                                                    <td> : {{ $pendaftar->pasien->pasien_agama }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        {{-- <div class="col-md-6"> --}}

                                        {{-- </div> --}}
                                    </div>
                                    @endforeach
                                </div>
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                        <!-- Messages-->
                        <!-- end card-->
                    </div> <!-- end col-->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content mb-1">{{-- tab-pane keluhan --}}
                                    <div class="row mb-3">
                                        <div class="keluhan-list">
                                            @foreach ($dtpendaftar as $list)
                                                <div class="keluhan-item">
                                                    <label>Keluhan:</label>
                                                    <textarea class="form-control" rows="3" readonly>{{ $list->keluhan }}</textarea>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>{{-- end tab-pane keluhan --}}

                                <div class="tab-content mb-1">{{-- tabel diagnosa --}}
                                    <div class="row mb-1">
                                        <div class="table-responsive">
                                            <table class="table table-centered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Tanggal Diagnosa</th>
                                                        <th>Diagnosa</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="kamarList">
                                                    <?php $totalharga = 0; ?>
                                                    @foreach ($dtdiagnosa as $diagnosa)
                                                        <tr id="row-{{ $diagnosa->id_diagnosa_pasieninap }}">
                                                            <td>{{ $diagnosa->tanggal }}</td>
                                                            <td>{{ $diagnosa->diagnosa }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>{{-- end tabel diagnosa --}}

                                <div class="tab-content mb-1">{{-- tabel kamarinap --}}
                                    <div class="row mb-1">
                                        <div class="table-responsive">
                                            <table class="table table-centered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Nama Kamar</th>
                                                        <th>Nomor Kamar</th>
                                                        <th>Tanggal Masuk</th>
                                                        <th>Tanggal Keluar</th>
                                                        <th>Lama</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="kamarList">
                                                    <?php $totalharga = 0; ?>
                                                    @foreach ($dtlistkamar as $kamar)
                                                        <tr id="row-{{ $kamar->id_kamar_pasieninap }}">
                                                            <td>{{ $kamar->kamar->nama_kamar_inap }}</td>
                                                            <td class="text-center">
                                                                {{ $kamar->kamar->nomor_kamar_inap }}</td>
                                                            <td>{{ $kamar->tanggal_masuk }}</td>
                                                            <td>{{ $kamar->tanggal_keluar }}</td>

                                                            @php
                                                                $tanggalMasuk = new DateTime($kamar->tanggal_masuk);
                                                                $tanggalKeluar = new DateTime($kamar->tanggal_keluar);
                                                                $selisih = $tanggalMasuk->diff($tanggalKeluar)->days;

                                                                $kamarinap = $kamar->kamar->harga_kamar_inap;
                                                                $harga = $kamarinap * $selisih;
                                                                $totalharga += $harga;
                                                            @endphp

                                                            <td>{{ $selisih }}</td>
                                                            <td>{{ number_format($kamarinap, 0, ',', '.') }}</td>
                                                            <td>{{ number_format($harga, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="6" class="text-end"><strong>Grand
                                                                Total:</strong></td>
                                                        <td><b>{{ number_format($totalharga, 0, ',', '.') }}</b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>{{-- end tabel kamarinap --}}

                                <div class="tab-content mb-1">{{-- tabel obat --}}
                                    <div class="row mb-1">
                                        <div class="table-responsive">
                                            <table class="table table-centered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Kategori Obat</th>
                                                        <th>Qty</th>
                                                        <th>Status</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="obatList">
                                                    @php
                                                        $totalhargaobat = 0;
                                                    @endphp
                                                    @foreach ($dtlistobat as $obat)
                                                        <tr id="row-{{ $obat->list_id }}">
                                                            <td>{{ $obat->nama_obat }}</td>
                                                            <td>{{ $obat->kategori_obat }}</td>
                                                            <td>{{ $obat->qty }}</td>
                                                            <td>{{ $obat->status }}</td>
                                                            <td>{{ number_format($obat->obat->harga_jual, 0, ',', '.') }}
                                                            </td>
                                                            @php
                                                                $harga = $obat->qty * $obat->obat->harga_jual;
                                                                $totalhargaobat += $harga;
                                                            @endphp
                                                            <td class="text-end">
                                                                {{ number_format($harga, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="5" class="text-end"><strong>Grand
                                                                Total:</strong></td>
                                                        <td class="text-end">
                                                            <b>{{ number_format($totalhargaobat, 0, ',', '.') }}</b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>{{-- end tabel obat --}}

                                <div class="tab-content mb-1">{{-- tab-pane tindakan --}}
                                    <div class="row mb-1">
                                        <div class="table-responsive">
                                            <table class="table table-centered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Tindakan</th>
                                                        <th>Biaya</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="obatList">
                                                    @php
                                                        $totalhargatindakan = 0;
                                                    @endphp
                                                    @foreach ($dtlisttindakan as $tindakan)
                                                        <tr id="row-{{ $obat->list_id }}">
                                                            <td>{{ $tindakan->tindakan->nama_tindakan }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($tindakan->tindakan->harga_tindakan, 0, ',', '.') }}
                                                            </td>
                                                            @php
                                                                $totalhargatindakan += $tindakan->tindakan->harga_tindakan;
                                                            @endphp
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Grand Total:</strong></td>
                                                        <td class="text-end">
                                                            <b>{{ number_format($totalhargatindakan, 0, ',', '.') }}</b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>{{-- end tab-pane tindakan --}}

                                <div class="tab-content mb-1">{{-- tabel rujukan --}}
                                    <div class="row mb-1">
                                        <div class="table-responsive">
                                            <table class="table table-centered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Rujukan</th>
                                                        <th>Tindakan</th>
                                                        <th>Biaya</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="obatList">
                                                    <?php
                                                    $totalhargarujukan = 0;
                                                    ?>
                                                    @foreach ($dtlistrujukan as $rujukan)
                                                        <tr id="row-{{ $rujukan->list_id }}">
                                                            <td>{{ $rujukan->lab->nama_lab }}</td>
                                                            <td>{{ $rujukan->tindakanlab->nama_tindakan }}</td>
                                                            <?php
                                                            $totalhargarujukan += $rujukan->tindakanlab->harga_tindakan;
                                                            ?>
                                                            <td class="text-end">
                                                                {{ number_format($rujukan->tindakanlab->harga_tindakan, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="text-end"><strong>Grand
                                                                Total:</strong></td>
                                                        <td class="text-end">
                                                            <b>{{ number_format($totalhargarujukan, 0, ',', '.') }}</b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>{{-- end tabel rujukan --}}

                                @php
                                    $grandtotal = 0;

                                    $totalhargaKamar = 0;
                                    foreach ($dtlistkamar as $kamar) {
                                        $tanggalMasuk = new DateTime($kamar->tanggal_masuk);
                                        $tanggalKeluar = new DateTime($kamar->tanggal_keluar);
                                        $selisih = $tanggalMasuk->diff($tanggalKeluar)->days;

                                        $kamarinap = $kamar->kamar->harga_kamar_inap;
                                        $harga = $kamarinap * $selisih;
                                        $totalhargaKamar += $harga;
                                    }

                                    $totalhargaObat = 0;
                                    foreach ($dtlistobat as $obat) {
                                        $harga = $obat->qty * $obat->obat->harga_jual;
                                        $totalhargaObat += $harga;
                                    }

                                    $totalhargaTindakan = 0;
                                    foreach ($dtlisttindakan as $tindakan) {
                                        $totalhargaTindakan += $tindakan->tindakan->harga_tindakan;
                                    }
                                    $totalhargaRujukan = 0;
                                    foreach ($dtlistrujukan as $rujukan) {
                                        $totalhargaRujukan += $rujukan->tindakanlab->harga_tindakan;
                                    }

                                    $grandtotal = $totalhargaKamar + $totalhargaObat + $totalhargaTindakan + $totalhargaRujukan;
                                @endphp

                                <div class="tab-content mb-1">
                                    <table class="table">
                                        <tbody>
                                            <tr class="mb-3 mt-2 m-3">
                                                <td class="col-md-2"><label for="grandtotal"
                                                        class="form-label-md-6 text-dark">Grandtotal </label>
                                                </td>
                                                <td class="col-md-4 text-end"><label for="grandtotal"
                                                        class="form-label-md-6 font-weight-bold text-dark"><b>{{ number_format($grandtotal, 0, ',', '.') }}</b></label>
                                                </td>
                                            </tr>
                                            <tr class="mb-3 mt-2 m-3">
                                                <td class="col-md-4"><label for="grandtotal"
                                                        class="form-label-md-6">Terbilang </label></td>
                                                <td class="col-md-8"><label for="grandtotal"
                                                        class="form-label-md-6">{{ $terbilanggrandtotal }}</label>
                                                </td>
                                            </tr>
                                            @foreach ($dtpendaftar as $pendaftar)
                                                <tr class="mb-3 mt-2 m-3">
                                                    <td class="col-md-2"><label for="dibayar"
                                                            class="form-label-md-6 text-dark">Dibayar </label></td>
                                                    <td class="col-md-4 text-end"><label for="dibayar"
                                                            class="form-label-md-6 font-weight-bold text-dark"><b>{{ number_format($pendaftar->dibayar, 0, ',', '.') }}</b></label>
                                                    </td>
                                                </tr>
                                                <tr class="mb-3 mt-2 m-3">
                                                    <td class="col-md-2"><label for="kembalian"
                                                            class="form-label-md-6 text-dark">Kembalian </label></td>
                                                    <td class="col-md-4 text-end"><label for="kembalian"
                                                            class="form-label-md-6 font-weight-bold text-dark"><b>{{ number_format($pendaftar->kembalian, 0, ',', '.') }}</b></label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>{{-- end car-body --}}
                            <div class="tab-content mb-1">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-start">
                                                <p id="printDate" class="mb-0"></p>
                                                <p class="mb-0">{{ $namaKasir }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end tab-content -->
                    </div> <!-- end card body -->
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
