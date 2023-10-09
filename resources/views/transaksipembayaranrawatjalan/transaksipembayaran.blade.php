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
                                <li class="breadcrumb-item"><a
                                        href="{{ route('transaksi-pembayaran-rawatjalan') }}">Transaksi Pembayaran</a></li>
                                <li class="breadcrumb-item active">Pasien Rawat Jalan</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Transaksi Pembayaran Pasien Rawat Jalan</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-5">
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <div class="text-sm-end">
                                        <div class="input-group">
                                            <input type="text" class="typeahead form-control" name="search"
                                                id="search" placeholder="Cari Nama Pasien">
                                            <button class="input-group-text btn btn-primary btn-sm" type="button"
                                                id="search-btn"><i class="uil-search-alt"></i></button>
                                        </div>
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Pendaftaran</th>
                                            <th>Nama Pasien</th>
                                            <th>Status Pasien</th>
                                            <th>Status Pemeriksaan</th>
                                            <th>Status Pengobatan</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-transaksi">
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtpendaftar as $item)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>{{ $item->kode_pendaftaran }}</td>
                                                <td>{{ $item->pasien->pasien_nama }}</td>
                                                <td>
                                                    @if ($item->status_pasien === 'Umum')
                                                        <span class="badge bg-success">{{ $item->status_pasien }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $item->status_pasien }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status_pemeriksaan === 'Tertangani')
                                                        <span class="badge bg-success">Tertangani</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum tertangani</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status_obat === 'Tertangani')
                                                        <span class="badge bg-success">Tertangani</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum tertangani</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->dibayar !== 0)
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <a href="{{ route('transaksi-pembayaran-rawatjalan.detail', $item->kode_pendaftaran) }}"
                                                            type="button" class="btn btn-primary" data-transaksi-id=""
                                                            onclick="">Lihat Detail</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->dibayar !== 0)
                                                        <button type="button" class="btn btn-primary"
                                                            data-transaksi-id="{{ $item->kode_pendaftaran }}"
                                                            onclick="printResi('{{ $item->kode_pendaftaran }}')"><i
                                                                class="uil-print"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $rowNumber++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="mt-3 text-center">
                        <div class="pagination">
                            {{ $dtpendaftar->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search-btn").click(function() {
                var searchTerm = $("#search").val();
                performSearch(searchTerm);
            });

            function performSearch(searchTerm) {
                $.ajax({
                    url: "{{ route('search.transaksi-pembayaran-rawatjalan') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        cari: searchTerm
                    },
                    success: function(data) {
                        displaySearchResults(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function displaySearchResults(data) {
                var resultList = "";
                var rowNumber = 1;

                if (data.length > 0) {
                    data.forEach(function(item) {
                        var badgestatuspasien = item.status_pasien === 'Umum' ? 'btn-success' :
                            'btn-danger';
                        var badgestatuspengobatan = item.status_obat === 'Tertangani' ?
                            'btn-success' : 'btn-danger';
                        var badgestatuspemeriksaan = item.status_pemeriksaan === 'Tertangani' ?
                            'btn-success' : 'btn-danger';
                        var badgesdibayar = item.dibayar !== 0 ?
                            'btn-success' : 'btn-danger';

                        resultList += "<tr>" +
                            "<td>" + rowNumber + "</td>" +
                            "<td>" + item.kode_pendaftaran + "</td>" +
                            "<td>" + item.pasien.pasien_nama + "</td>" +
                            "<td><button class='btn " + badgestatuspasien + " btn-sm'>" + item
                            .status_pasien + '</button></td>' +
                            "<td><button class='btn " + badgestatuspemeriksaan + " btn-sm'>" + item
                            .status_pemeriksaan + '</button></td>' +
                            "<td><button class='btn " + badgestatuspengobatan + " btn-sm'>" + item
                            .status_obat + '</button></td>' +
                            "<td><a href='transaksi-pembayaran-rawatjalan/detail/update/print/" + item
                            .kode_pendaftaran +
                            "' class='btn btn-primary'><i class='uil-print'></i>" +
                            "</a></td>" +
                            "</tr>";
                        rowNumber++;
                    });
                } else {
                    resultList = "<tr><td colspan='12'>Tidak ada hasil ditemukan.</td></tr>";
                }

                $("#data-transaksi").html(resultList);
            }

            function resetSearchResults() {
                var searchTerm = $("#search").val();
                $("#data-transaksi").empty();
            }
        });

        function printResi(kode) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/admin/transaksi-pembayaran-rawatjalan/detail/update/print/' + kode, {
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
    </script>
@endsection
