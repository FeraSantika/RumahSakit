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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">List Daftar Pasien</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">List Daftar Pasien</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                {{-- <div class="col-sm-2">
                                    <a href="{{ route('daftar.online.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Pendaftaran</a>
                                </div> --}}
                                <div class="col-sm-5"></div>
                                {{-- <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="typeahead form-control" name="search" id="search"
                                            placeholder="Cari Pasien">
                                        <button class="input-group-text btn btn-primary btn-sm" type="button"
                                            id="search-btn"><i class="uil-search-alt"></i></button>
                                    </div>
                                </div><!-- end col--> --}}
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Kode Pendaftaran</th>
                                                <th scope="col">Nama Pasien</th>
                                                <th scope="col">Status Pasien</th>
                                                <th scope="col">Poli</th>
                                                <th scope="col">Keluhan</th>
                                                <th scope="col">Status Pemeriksaan</th>
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
                                                    <td class="text-end">
                                                        @if ($item->status_pemeriksaan === 'Belum tertangani')
                                                            <a href="{{ route('detail.list-daftar-pasien', $item->pasien_id) }}"
                                                                type="button" class="btn btn-primary" data-transaksi-id=""
                                                                onclick="">Lihat Detail</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php
                                                    $rowNumber++;
                                                @endphp
                                            @endforeach
                                            @if (session('diagnosa_updated'))
                                                <div class="alert alert-success">
                                                    Pengisian data diagnosa berhasil!
                                                </div>
                                            @endif
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
                        <p class="mt-2">
                            Menampilkan {{ $dtpendaftar->count() }} data dari {{ $dtpendaftar->total() }} total data.
                        </p>
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
