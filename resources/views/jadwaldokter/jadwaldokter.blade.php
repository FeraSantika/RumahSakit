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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Master </a></li>
                                <li class="breadcrumb-item active">Jadwal Dokter</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Jadwal Dokter</h4>
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
                                    <a href="{{ route('jadwal-dokter.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Jadwal</a>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <div class="text-sm-end">
                                        {{-- <div class="input-group">
                                            <input type="text" class="typeahead form-control" name="search"
                                                id="search" placeholder="Cari Jadwal">
                                            <button class="input-group-text btn btn-primary btn-sm" type="button"
                                                id="search-btn"><i class="uil-search-alt"></i></button>
                                        </div> --}}
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Dokter</th>
                                            <th>Hari</th>
                                            <th>Waktu</th>
                                            <th style="width: 95px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-jadwal">
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtjadwal as $item)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>{{ $item->user->User_name }}</td>
                                                <td>{{ $item->nama_hari }}</td>
                                                <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                                                <td class="table-action">
                                                    <a href="{{ route('jadwal-dokter.edit', $item->id_jadwal) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->id_tindakan }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->id_tindakan }}"
                                                        action="{{ route('jadwal-dokter.destroy', $item->id_jadwal) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
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
                            {{ $dtjadwal->links('pagination::bootstrap-4') }}
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
                    url: "{{ route('search.jadwal-dokter') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        cari: searchTerm
                    },
                    success: displaySearchResults,
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
                        resultList += createTableRow(item, rowNumber);
                        rowNumber++;
                    });
                } else {
                    resultList = "<tr><td colspan='5'>Tidak ada hasil ditemukan.</td></tr>";
                }

                $("#data-jadwal").html(resultList);
            }

            function createTableRow(item, rowNumber) {
                return "<tr>" +
                    "<td>" + rowNumber + "</td>" +
                    "<td>" + item.user.User_name + "</td>" + // Menampilkan Nama Dokter
                    "<td>" + item.nama_hari + "</td>" +
                    "<td>" + item.jam_mulai + " - " + item.jam_selesai + "</td>" +
                    "<td class='table-action'>" +
                    createEditLink(item.id_jadwal) +
                    createDeleteLink(item.id_jadwal) +
                    "</td>" +
                    "</tr>";
            }

            function createEditLink(id) {
                return "<a href='jadwal-dokter/edit/" + id + "' class='action-icon'>" +
                    "<i class='mdi mdi-square-edit-outline'></i></a>";
            }

            function createDeleteLink(id) {
                return "<a href='jadwal-dokter/destroy/" + id + "' class='action-icon' " +
                    "onclick='event.preventDefault(); if (confirm(\"Apakah Anda yakin ingin menghapus?\")) " +
                    "document.getElementById(\"delete-form-" + id + "\").submit();'>" +
                    "<i class='mdi mdi-delete'></i></a>" +
                    "<form id='delete-form-" + id + "' " +
                    "action='jadwal-dokter/destroy/" + id + "' method='POST'>" +
                    "@csrf @method('DELETE')</form>";
            }

            function resetSearchResults() {
                var searchTerm = $("#search").val();
                $("#data-jadwal").empty();
            }
        });
    </script>
@endsection --}}
