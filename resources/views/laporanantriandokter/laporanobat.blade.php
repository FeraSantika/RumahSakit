@extends('main')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan Obat</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan Obat Pasien Rawat
                                        Inap</a>
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">Laporan Obat Pasien Rawat Inap</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="row mb-2 align-items-end">
                                    <div class="col">
                                        <label for="tanggalAwal" class="form-label form-inline">Tanggal Awal :</label>
                                        <input type="date" id="tanggalAwal" name="tanggalAwal" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="tanggalAkhir" class="form-label form-inline">Tanggal Akhir :</label>
                                        <input type="date" id="tanggalAkhir" name="tanggalAkhir" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="statusPasien" class="form-label form-inline">Status Pasien :</label>
                                        <select id="statusPasien" name="statusPasien" class="form-control">
                                            <option value="">Pilih Status Pasien</option>
                                            <option value="BPJS">BPJS</option>
                                            <option value="Umum">Umum</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="statusPemeriksaan" class="form-label form-inline">Status Pemeriksaan
                                            :</label>
                                        <select id="statusPemeriksaan" name="statusPemeriksaan" class="form-control">
                                            <option value="">Pilih Status Pemeriksaan</option>
                                            <option value="Tertangani">Tertangani</option>
                                            <option value="Belum tertangani">Belum tertangani</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-success"
                                            onclick="tampilkanData()">Filter</button>
                                    </div>
                                    <div class="col-sm-2 mt-3">
                                        <a href="#" type="submit" class="btn btn-light mb-2 me-1"
                                            onclick="exportExcel()"><i class="uil-print"></i>
                                            Excel</a>
                                        <a href="#" class="btn btn-primary mb-2 me-1"
                                            onclick="exportPDFWithDates()"><i class="uil-print"></i> PDF</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0" id="tabelobat">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Nama Obat</th>
                                                <th scope="col">Jumlah Terjual</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datarawatjalan">
                                            @php
                                                $rowNumber = 1;
                                            @endphp
                                            @foreach ($dtobat as $item)
                                                <tr>
                                                    <td>{{ $rowNumber }}</td>
                                                    <td>{{ $item->nama_obat }}</td>
                                                    <td>{{ $item->total_qty }}</td>
                                                </tr>
                                                @php
                                                    $rowNumber++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="mt-3 text-center">
                        <div class="pagination">
                            {{ $dtobat->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection
@section('script')
    <script>
        function tampilkanData() {
            const tanggalAwal = $("#tanggalAwal").val();
            const tanggalAkhir = $("#tanggalAkhir").val();
            const statusPasien = $("#statusPasien").val();
            const statusPemeriksaan = $("#statusPemeriksaan").val();

            const hasilData = document.getElementById('tabelobat');
            hasilData.innerHTML = '';

            const url = `/admin/laporan-obatInap/get_data?tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}
            &statusPasien=${statusPasien}&statusPemeriksaan=${statusPemeriksaan}`;
            fetch(url)
                .then(response => response.json())
                .then(dataTerfilter => {
                    if (dataTerfilter.length > 0) {
                        let tableHTML = '<table class="table table-centered w-100 dt-responsive nowrap">';
                        tableHTML += '<thead>';
                        tableHTML += '<tr>';
                        tableHTML += '<th>Nama Obat</th>';
                        tableHTML += '<th>Jumlah Terjual</th>';
                        tableHTML += '</tr>';
                        tableHTML += '</thead>';
                        tableHTML += '<tbody>';

                        dataTerfilter.forEach(item => {
                            console.log(item)
                            tableHTML += '<tr>';
                            tableHTML += `<td>${item.nama_obat}</td>`;
                            tableHTML += `<td>${item.total_qty}</td>`;
                            tableHTML += `<td></td>`;
                            tableHTML += '</tr>';
                        });

                        tableHTML += '</tbody> </table>';
                        hasilData.innerHTML = tableHTML;
                    } else {
                        hasilData.innerHTML = 'Tidak ada data pada rentang tanggal yang dipilih.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hasilData.innerHTML = 'Terjadi kesalahan saat memuat data.';
                });
        }

        function formatDate(dateString) {
            const formattedDate = new Date(dateString).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
            return formattedDate.split('/').join('/');
        }

        function exportPDFWithDates() {
            var tanggalAwal = document.getElementById('tanggalAwal').value;
            var tanggalAkhir = document.getElementById('tanggalAkhir').value;
            const statusPasien = $("#statusPasien").val();
            const statusPemeriksaan = $("#statusPemeriksaan").val();

            var pdfURL = "{{ route('laporan-obatInap.export-pdf') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" +
                tanggalAkhir;

            if (statusPasien) {
                pdfURL += "&statusPasien=" + statusPasien;
            }

            if (statusPemeriksaan) {
                pdfURL += "&statusPemeriksaan=" + statusPemeriksaan;
            }

            window.location.href = pdfURL;
        }

        function exportExcel() {
            var tanggalAwal = document.getElementById('tanggalAwal').value;
            var tanggalAkhir = document.getElementById('tanggalAkhir').value;
            const statusPasien = $("#statusPasien").val();
            const statusPemeriksaan = $("#statusPemeriksaan").val();

            var excelURL = "{{ route('laporan-obatInap.export-excel') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" + tanggalAkhir;

            if (statusPasien) {
                excelURL += "&statusPasien=" + statusPasien;
            }

            if (statusPemeriksaan) {
                excelURL += "&statusPemeriksaan=" + statusPemeriksaan;
            }

            window.location.href = excelURL;
        }
    </script>
@endsection
