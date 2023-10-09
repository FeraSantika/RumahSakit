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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan Pendaftaran</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan Pasien Rawat Jalan</a>
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">Laporan Hasil Pasien Rawat Jalan</h4>
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
                                    <table class="table table-centered table-nowrap mb-0" id="tabelrawatjalan">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Dokter</th>
                                                <th scope="col">Kode Pendaftaran</th>
                                                <th scope="col">Nama Pasien</th>
                                                <th scope="col">Status Pasien</th>
                                                <th scope="col">Poli</th>
                                                <th scope="col">Keluhan</th>
                                                <th scope="col">Status Pemeriksaan</th>
                                                <th scope="col">Total Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody id="datarawatjalan">
                                            @php
                                                $rowNumber = 1;
                                                $grandtotal = 0;
                                            @endphp
                                            @foreach ($dtpendaftar as $item)
                                                <tr>
                                                    <td>{{ $rowNumber }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                                    <td>
                                                        @if ($item->aksespoli)
                                                            {{ $item->aksespoli->user->User_name }}
                                                        @else
                                                            Akses Poli Not Available
                                                        @endif
                                                    </td>

                                                    <td>{{ $item->kode_pendaftaran }}</td>
                                                    <td>
                                                        @if (isset($item->pasien))
                                                            {{ $item->pasien->pasien_nama }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->status_pasien === 'Umum')
                                                            <span class="badge bg-success">{{ $item->status_pasien }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ $item->status_pasien }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($item->poli))
                                                            {{ $item->poli->nama_poli }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->keluhan }}</td>
                                                    <td>
                                                        @if ($item->status_pemeriksaan === 'Tertangani')
                                                            <span
                                                                class="badge bg-success">{{ $item->status_pemeriksaan }}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-danger">{{ $item->status_pemeriksaan }}</span>
                                                        @endif
                                                    </td>
                                                    <td> Rp. {{ number_format($item->grandtotal, 0, ',', '.') }}</td>
                                                </tr>
                                                @php
                                                    $rowNumber++;
                                                    $grandtotal += $item->grandtotal;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td colspan="9"><strong>Grandtotal:</strong></td>
                                                <td><strong>Rp. {{ number_format($grandtotal, 0, ',', '.') }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="mt-3 text-center">
                        <div class="pagination">
                            {{ $dtpendaftar->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div> <!-- end col -->
            </div><!-- end row -->
        </div> <!-- container -->

    </div>
@endsection
@section('script')
    <script>
        function tampilkanData() {
            const tanggalAwal = $("#tanggalAwal").val();
            const tanggalAkhir = $("#tanggalAkhir").val();
            const statusPasien = $("#statusPasien").val();
            const pilihPoli = $("#pilihPoli").val();
            const statusPemeriksaan = $("#statusPemeriksaan").val();
            let totalGrandtotal = 0;

            const hasilData = document.getElementById('tabelrawatjalan');
            hasilData.innerHTML = '';

            const url =
                `/admin/laporan-hasilpasienJalan/get_data?tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}
                &statusPasien=${statusPasien}&pilihPoli=${pilihPoli}&statusPemeriksaan=${statusPemeriksaan}`;
            fetch(url)
                .then(response => response.json())
                .then(dataTerfilter => {
                    if (dataTerfilter.length > 0) {
                        let tableHTML = '<table class="table table-centered w-100 dt-responsive nowrap">';
                        tableHTML += '<thead>';
                        tableHTML += '<tr>';
                        tableHTML += '<th>Tanggal</th>';
                        tableHTML += '<th>Dokter</th>';
                        tableHTML += '<th>Kode</th>';
                        tableHTML += '<th>Nama Pasien</th>';
                        tableHTML += '<th>Status Pasien</th>';
                        tableHTML += '<th>Poli</th>';
                        tableHTML += '<th>Keluhan</th>';
                        tableHTML += '<th>Status Pemeriksaan</th>';
                        tableHTML += '<th>Total Pembayaran</th>';
                        tableHTML += '</tr>';
                        tableHTML += '</thead>';
                        tableHTML += '<tbody>';

                        dataTerfilter.forEach(item => {
                            totalGrandtotal += item.grandtotal;
                            var badgestatuspemeriksaan = item.status_pemeriksaan === 'Tertangani' ?
                                'btn-success' :
                                'btn-danger';
                            var badgestatuspaasien = item.status_pasien === 'Umum' ? 'btn-success' :
                                'btn-danger';

                            tableHTML += '<tr>';
                            tableHTML += `<td>${formatDate(item.created_at)}</td>`;
                            if (item.user) {
                                tableHTML += `<td>${item.user.User_name}</td>`;
                            } else {
                                tableHTML += '<td>Nama Dokter Tidak Tersedia</td>';
                            }
                            tableHTML += `<td>${item.kode_pendaftaran}</td>`;
                            tableHTML += `<td>${item.pasien.pasien_nama}</td>`;
                            tableHTML += `<td><button class='btn ` + badgestatuspaasien + ` btn-sm'>` + item
                                .status_pasien + `</button></td>`;
                            tableHTML += `<td>${item.poli.nama_poli }</td>`;
                            tableHTML += `<td>${item.keluhan }</td>`;
                            tableHTML += `<td><button class='btn ` + badgestatuspemeriksaan + ` btn-sm'>` + item
                                .status_pemeriksaan + `</button></td>`;
                            tableHTML +=
                                `<td>Rp ${new Intl.NumberFormat('id-ID').format(item.grandtotal)}</td>`;
                            tableHTML += `<td></td>`;
                            tableHTML += '</tr>';
                        });

                        tableHTML += '<tr>';
                        tableHTML += '<td colspan="8" class="text-start"><strong> Grandtotal:</strong></td>';
                        tableHTML +=
                            `<td class="text-start"><strong>Rp ${new Intl.NumberFormat('id-ID').format(totalGrandtotal)}</strong></td>`;
                        tableHTML += '<td></td>';
                        tableHTML += '</tr>';

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
            var statusPasien = document.getElementById('statusPasien').value;
            var pilihPoli = document.getElementById('pilihPoli').value;
            var statusPemeriksaan = document.getElementById('statusPemeriksaan').value;

            var pdfURL = "{{ route('laporan-hasilpasienJalan.export-pdf') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" +
                tanggalAkhir;

            if (statusPasien) {
                pdfURL += "&statusPasien=" + statusPasien;
            }

            if (statusPemeriksaan) {
                pdfURL += "&statusPemeriksaan=" + statusPemeriksaan;
            }

            if (pilihPoli) {
                pdfURL += "&pilihPoli=" + pilihPoli;
            }

            window.location.href = pdfURL;
        }

        function exportExcel() {
            var tanggalAwal = document.getElementById('tanggalAwal').value;
            var tanggalAkhir = document.getElementById('tanggalAkhir').value;
            var statusPasien = document.getElementById('statusPasien').value;
            var pilihPoli = document.getElementById('pilihPoli').value;
            var statusPemeriksaan = document.getElementById('statusPemeriksaan').value;

            console.log("Status Pasien:", statusPasien);

            var excelURL = "{{ route('laporan-hasilpasienJalan.export-excel') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" + tanggalAkhir;

            if (statusPasien) {
                excelURL += "&statusPasien=" + statusPasien;
            }

            if (statusPemeriksaan) {
                excelURL += "&statusPemeriksaan=" + statusPemeriksaan + "&pilihPoli=" + pilihPoli;
            }

            if (pilihPoli) {
                excelURL += "&pilihPoli=" + pilihPoli;
            }

            window.location.href = excelURL;
        }
    </script>
@endsection
