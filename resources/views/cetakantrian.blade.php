<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>simRS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://antrian.retechapps.com/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://antrian.retechapps.com/assets/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
        href="https://antrian.retechapps.com/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://antrian.retechapps.com/assets/plugins/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="https://antrian.retechapps.com/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="https://antrian.retechapps.com/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="https://antrian.retechapps.com/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- jQuery -->
    <script src="https://antrian.retechapps.com/assets/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/playAudio.js') }}"></script>


    <!-- Flex Align Center Horizontal & Custom Color for Navbar &-->
    <style>
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            right: 0px;
            width: 100%;
            z-index: 1000;
            padding: 2px;
            margin: auto;
            text-align: center;
            float: none;
            box-shadow: 0px -2px 10px #c0c0c0;
            background-color: var(--primary);
            color: #fff;
        }
    </style>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="hold-transition sidebar-mini" onload="startTime()">
    <div class="wrapper hw-100">
        <!-- Navbar -->
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand navbar-primary"
                    style="background-color: #14959a!important; color: #ffffff!important;">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <div class="flex-container">
                                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($rs->logo_rumahsakit)) }}"
                                    alt="Logo" height="110" class="p-2">
                                <div class="nav-link align-items-center">
                                    <h1 class="display-4">
                                        <b>{{ $rs->nama_rumahsakit }}</b>
                                    </h1>
                                    <h5>{{ $rs->alamat_rumahsakit }} ||
                                        {{ $rs->telp_rumahsakit }} ||
                                        {{ $rs->email_rumahsakit }}</h5>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- Right navbar links -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item d-none d-sm-inline-block">
                            <div class="nav-link">
                                <h4>
                                    <b>
                                        <div id="timer"></div>
                                    </b>
                                </h4>
                            </div>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                                <h2><i class="ri-fullscreen-line font-22" style="color: #ffffff"></i></h2>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <section class="content">
            <div class="add-audio" style="display: none">
                <audio id="bell-announcement">
                    <source src="https://antrian.retechapps.com/assets/sound/bell-announcement.mp3" type="audio/ogg">
                </audio>
                <audio id="bell-clossing">
                    <source src="https://antrian.retechapps.com/assets/sound/bell-clossing.mp3" type="audio/ogg">
                </audio>
            </div>

            <div class="row mt-5 mr-2 mb-5 ml-2">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="gallery-item mr-3">
                                <div class="card widget-flat"
                                    style="height: 150px;background-color: #14959a!important; color: #ffffff!important;"
                                    onclick="printantriandokter(1)">
                                    <div class="card-body d-flex flex-column">
                                        <h4>Poli 1</h4>
                                        <h1>Anak</h1>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="gallery-item mr-3">
                                <div class="card widget-flat"
                                    style="height: 150px; background-color: #14959a!important; color: #ffffff!important;"
                                    onclick="printantriandokter(2)">
                                    <div class="card-body">
                                        <h4>Poli 2</h4>
                                        <h1>Gigi</h1>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="gallery-item mr-3">
                                <div class="card widget-flat"
                                    style="height: 150px; background-color: #14959a!important; color: #ffffff!important;"
                                    onclick="printantriandokter(3)">
                                    <div class="card-body">
                                        <h4>Poli 3</h4>
                                        <h1>Mata</h1>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="gallery-item mr-3">
                                <div class="card widget-flat"
                                    style="height: 150px; background-color: #14959a!important; color: #ffffff!important;"
                                    onclick="printantriandokter(8)">
                                    <div class="card-body">
                                        <h4>Poli 8</h4>
                                        <h1>THT</h1>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="gallery-item mr-3">
                                <div class="card widget-flat"
                                    style="height: 150px; background-color: #14959a!important; color: #ffffff!important;"
                                    onclick="printantriandokter(9)">
                                    <div class="card-body">
                                        <h4>Poli 9</h4>
                                        <h1>Orthodonti</h1>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="gallery-item mr-3">
                                <div class="card widget-flat"
                                    style="height: 150px; background-color: #14959a!important; color: #ffffff!important;"
                                    onclick="printantriandokter(11)">
                                    <div class="card-body">
                                        <h4>Poli 11</h4>
                                        <h1>Gizi</h1>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12"></div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="gallery-item mr-3">
                                <div class="card widget-flat"
                                    style="height: 150px; background-color: #14959a!important; color: #ffffff!important;"
                                    @if ($cetakantrianapotek) onclick="printantrianapotek('{{ $cetakantrianapotek->id_antrian }}')"
                                @else
                                    onclick="printantrianapotek(0)" @endif>
                                    <div class="card-body">
                                        <h1>Apotek</h1>
                                    </div> <!-- end card-body-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12"></div>
                    </div>
                </div>
        </section>

        <div class="footer" style="background-color: #ffdd00!important; color: #ffffff!important;">
            <marquee>Selamat datang di Rumah Sakit {{ $rs->nama_rumahsakit }}. Kami siap melayani Anda.Kami
                memprioritaskan pelayanan terbaik untuk Anda.Pastikan Anda membawa kartu identitas saat mendaftar
            </marquee>
        </div>
    </div>
    <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 4 -->
    <script src="https://antrian.retechapps.com/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://antrian.retechapps.com/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="https://antrian.retechapps.com/assets/plugins/toastr/toastr.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="https://antrian.retechapps.com/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
    </script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/jszip/jszip.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="https://antrian.retechapps.com/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://antrian.retechapps.com/assets/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->

    <!-- Recta JS for print antrian -->
    <script src="https://cdn.jsdelivr.net/npm/recta/dist/recta.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=6zFzZrfQ"></script>
    <script type="text/javascript">
        /*maksimal 30 nomor antrian dan 9 loket*/

        function startTime() {
            var hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);

            if (dd < 10) {
                dd = '0' + dd;
            }
            mm = getNamaBulan(mm);
            var namaHari = hari[today.getDay()];
            document.getElementById('timer').innerHTML =
                "" + namaHari + ", " + dd + " " + mm + " " + yyyy + " | " + h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }

        function getNamaBulan(bulan) {
            var namaBulan = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            return namaBulan[bulan - 1];
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        function printantriandokter(kode) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/admin/cetak-antrian/dokter/' + kode, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    var printWindow = window.open('', '_blank');
                    printWindow.document.write(data);
                    printWindow.document.close();
                    printWindow.print();
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function printantrianapotek(idAntrian, nomorAntrian) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_antrian', idAntrian);
            formData.append('nomor_antrian', nomorAntrian);

            fetch('/admin/cetak-antrian/apotek/' + idAntrian, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    var printWindow = window.open('', '_blank');
                    printWindow.document.write(data);
                    printWindow.document.close();
                    printWindow.print();
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        // const nomorAntrianElement = document.getElementById('nomor-antrian');
        // const namaPoli = document.getElementById('nama_poli');

        // function updateDataAntrian() {
        //     fetch("/get-nomor-antrian")
        //         .then(response => response.json())
        //         .then(data => {
        //             console.log(data);
        //             nomorAntrianElement.textContent = data.kode + " - " + data.nomor_antrian;
        //             namaPoli.textContent = data.nama_poli;
        //             if (data.status == 1) {
        //                 const nomor_antrian = data.nomor_antrian;
        //                 const nomor_loket = data.nama_poli;
        //                 const kode_poli = data.kode;
        //                 playAudioAntrian(kode_poli, nomor_antrian, nomor_loket);
        //             }
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });
        // }
        // setInterval(updateDataAntrian, 7000);
        // updateDataAntrian();

        // const antrianObat = document.getElementById('nomor-antrian_obat');

        // function updateDataAntrianObat() {
        //     fetch("/get-nomor-antrian-obat")
        //         .then(response => response.json())
        //         .then(data => {
        //             console.log(data);
        //             antrianObat.textContent = data.nomor_antrian;
        //             if (data.status == 1) {
        //                 const nomor_antrian = data.nomor_antrian;
        //                 playAudioAntrianObat(nomor_antrian);
        //             }
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });
        // }
        // setInterval(updateDataAntrianObat, 7000);
        // updateDataAntrianObat();
    </script>
</body>

</html>
