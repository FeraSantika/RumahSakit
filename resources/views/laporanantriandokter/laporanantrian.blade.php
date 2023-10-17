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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan Antrian</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan Antrian Pasien Rawat
                                        Jalan</a>
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">Laporan Antrian Pasien Rawat Jalan</h4>
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
                                        <label for="pilihPoli" class="form-label form-inline">Poli :</label>
                                        <select id="pilihPoli" name="pilihPoli" class="form-control">
                                            <option value="">Pilih Poli</option>
                                            @foreach ($poli as $item)
                                                <option value="{{ $item->id_poli }}">{{ $item->nama_poli }}
                                                </option>
                                            @endforeach
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
                                    <table class="table table-centered table-nowrap mb-0" id="tabelantrian">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Poli</th>
                                                <th scope="col">Jumlah Antrian</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataAntrian">
                                            @php
                                                $rowNumber = 1;
                                            @endphp
                                            @foreach ($dtantrian as $antrian)
                                                <tr>
                                                    <td>{{ $rowNumber }}</td>
                                                    <td>{{ $antrian->tanggal_antrian }}</td>
                                                    <td>{{ $antrian->poli->nama_poli }}</td>
                                                    <td>{{ $antrian->nomor_antrian }}</td>
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
                            {{-- {{ $dtobat->links('pagination::bootstrap-4') }} --}}
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
            const pilihPoli = $("#pilihPoli").val();

            const hasilData = document.getElementById('tabelantrian');
            hasilData.innerHTML = '';

            const url =
                `/admin/laporan-antriandokter/get_data?tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}
                &pilihPoli=${pilihPoli}`;
            fetch(url)
                .then(response => response.json())
                .then(dataTerfilter => {
                    if (dataTerfilter.length > 0) {
                        let tableHTML = '<table class="table table-centered w-100 dt-responsive nowrap">';
                        tableHTML += '<thead>';
                        tableHTML += '<tr>';
                        tableHTML += '<th>Tanggal</th>';
                        tableHTML += '<th>Poli</th>';
                        tableHTML += '<th>Jumlah Antrian</th>';
                        tableHTML += '</tr>';
                        tableHTML += '</thead>';
                        tableHTML += '<tbody>';

                        dataTerfilter.forEach(item => {
                            console.log(item)
                            tableHTML += '<tr>';
                            tableHTML += `<td>${item.tanggal_antrian}</td>`;
                            tableHTML += `<td>${item.poli.nama_poli}</td>`;
                            tableHTML += `<td>${item.nomor_antrian}</td>`;
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
            var pilihPoli = document.getElementById('pilihPoli').value;

            var pdfURL = "{{ route('laporan-antriandokter.export-pdf') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" +
                tanggalAkhir;

            if (pilihPoli) {
                pdfURL += "&pilihPoli=" + pilihPoli;
            }

            window.location.href = pdfURL;
        }

        function exportExcel() {
            var tanggalAwal = document.getElementById('tanggalAwal').value;
            var tanggalAkhir = document.getElementById('tanggalAkhir').value;
            var pilihPoli = document.getElementById('pilihPoli').value;

            var excelURL = "{{ route('laporan-antriandokter.export-excel') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" + tanggalAkhir;

            if (pilihPoli) {
                excelURL += "&pilihPoli=" + pilihPoli;
            }

            window.location.href = excelURL;
        }
    </script>
@endsection
