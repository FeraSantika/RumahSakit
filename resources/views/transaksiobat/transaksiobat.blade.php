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
                                <li class="breadcrumb-item active">Transaksi Obat</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Transaksi Obat</h4>
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
                                    {{-- <a href="{{ route('tindakan.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Tindakan</a> --}}
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
                                            <th>Status Pengobatan</th>
                                            <th>Action</th>
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
                                                    @if ($item->status_obat === 'Tertangani')
                                                        <span class="badge bg-success">Tertangani</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum tertangani</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status_obat === 'Belum tertangani')
                                                        <a href="{{ route('transaksi-obat.detail', $item->kode_pendaftaran) }}"
                                                            type="button" class="btn btn-primary" data-transaksi-id=""
                                                            onclick="">Lihat Detail</a>
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
                    url: "{{ route('search.transaksi-obat') }}",
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
                        var badgestatuspasien = item.status_pasien === 'Umum' ? 'badge bg-success' :
                            'badge bg-danger';
                        var badgestatusobat = item.status_obat === 'Tertangani' ? 'badge bg-success' :
                            'badge bg-danger';

                        resultList += "<tr>" +
                            "<td>" + rowNumber + "</td>" +
                            "<td>" + item.kode_pendaftaran + "</td>" +
                            "<td>" + item.pasien.pasien_nama + "</td>" +
                            "<td><span class='" + badgestatuspasien + "'>" + item.status_pasien +
                            "</span></td>";
                        // "<td><span class='" + badgestatusobat + "'>" + item.status_obat +
                        // "</span></td>" +
                        // "<td><a href='transaksi-obat/detail/" + item.id_tindakan +
                        // "' class='btn btn-primary'>" +
                        // "Lihat Detail</a></td>" +
                        // "</tr>";
                        if (item.status_obat === 'Tertangani') {
                            resultList += "<td><span class='" + badgestatusobat + "'>" + item.status_obat +
                                "</span></td>";
                        } else {
                            resultList += "<td><span class='" + badgestatusobat + "'>" + item.status_obat +
                                "</span></td>" +
                                "<td><a href='transaksi-obat/detail/" + item.kode_pendaftaran +
                                "' class='btn btn-primary'>" +
                                "Lihat Detail</a></td>";
                        }

                        resultList += "</tr>";

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
    </script>
@endsection
