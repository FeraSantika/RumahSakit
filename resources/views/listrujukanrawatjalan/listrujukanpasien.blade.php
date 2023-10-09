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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">List Rujukan Pasien</a></li>
                                <li class="breadcrumb-item active"><a href="javascript: void(0);">Pasien Rawat
                                        Jalan</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">List Rujukan Pasien Rawat Jalan</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-5"></div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Dokter</th>
                                                <th scope="col">Kode Pendaftaran</th>
                                                <th scope="col">Nama Pasien</th>
                                                <th scope="col">Status Pasien</th>
                                                <th scope="col" class="text-center">Lab</th>
                                                <th scope="col">Status Rujukan</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-pasien">
                                            @php
                                                $rowNumber = 1;
                                            @endphp
                                            @foreach ($dtpendaftar as $item)
                                                <tr>
                                                    <td>{{ $rowNumber }}</td>
                                                    <td>
                                                        @if ($item && $item->daftar && $item->daftar->user)
                                                            {{ $item->daftar->user->User_name }}
                                                        @else
                                                            Belum Tertangani Dokter
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->kode_pendaftaran }}</td>
                                                    <td>
                                                        @if (isset($item->daftar))
                                                            {{ $item->daftar->pasien->pasien_nama }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->daftar->status_pasien === 'Umum')
                                                            <span
                                                                class="badge bg-success">{{ $item->daftar->status_pasien }}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-danger">{{ $item->daftar->status_pasien }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->lab->nama_lab }}</td>
                                                    <td>
                                                        @if ($item->status === 'Tertangani')
                                                            <span class="badge bg-success">{{ $item->status }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ $item->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if ($item->status === 'Belum tertangani')
                                                            <a href="{{ route('detail.list-rujukan-pasienJalan', $item->list_id) }}"
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
{{-- @section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search-btn").click(function() {
                var searchTerm = $("#search").val();
                performSearch(searchTerm);
            });

            function performSearch(searchTerm) {
                $.ajax({
                    url: "{{ route('search.pasien') }}",
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
                        resultList += "<tr>" +
                            "<td>" + rowNumber + "</td>" +
                            "<td>" + item.pasien_kode + "</td>" +
                            "<td>" + item.pasien_NIK + "</td>" +
                            "<td>" + item.pasien_nama + "</td>" +
                            "<td>" + item.pasien_tempat_lahir + "</td>" +
                            "<td>" + item.pasien_tgl_lahir + "</td>" +
                            "<td><a href='javascript:void(0);' class='action-icon' onclick='edit(" + item
                            .pasien_kode + ")'>" +
                            "<i class='mdi mdi-square-edit-outline'></i></a>" +
                            "<a href='javascript:void(0)' onclick='hapus(" + item.pasien_kode +
                            ")' class='action-icon'>" +
                            "<i class='mdi mdi-delete'></i></a>" +
                            "<a href='javascript:void(0);' class='action-icon' onclick='detail(" + item
                            .pasien_kode + ")'>" +
                            "<i class='uil-file-search-alt'></i></a></td>" +
                            "</tr>";

                        rowNumber++;
                    });
                } else {
                    resultList = "<tr><td colspan='12'>Tidak ada hasil ditemukan.</td></tr>";
                }

                $("#data-pasien").html(resultList);
            }
        });
    </script>
@endsection --}}
