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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Master User</a></li>
                                <li class="breadcrumb-item active">Pasien</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Pasien</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-2">
                                    <a href="{{ route('pasien.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Pasien</a>
                                </div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="typeahead form-control" name="search" id="search"
                                            placeholder="Cari Pasien">
                                        <button class="input-group-text btn btn-primary btn-sm" type="button"
                                            id="search-btn"><i class="uil-search-alt"></i></button>
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Pasien</th>
                                            <th>NIK</th>
                                            <th>Nama Pasien</th>
                                            <th>Tempat lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Gender</th>
                                            <th> Alamat </th>
                                            <th>Agama</th>
                                            <th>Status perkawinan</th>
                                            <th>Pekerjaan</th>
                                            <th>Kewarganegaraan</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-pasien">
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtpasien as $item)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>{{ $item->pasien_kode }}</td>
                                                <td>{{ $item->pasien_NIK }}</td>
                                                <td>
                                                    {{ $item->pasien_nama }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_tempat_lahir }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_tgl_lahir }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_gender }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_alamat }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_agama }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_status }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_pekerjaan }}
                                                </td>
                                                <td>
                                                    {{ $item->pasien_kewarganegaraan }}
                                                </td>
                                                <td class="table-action">
                                                    <a href="{{ route('pasien.edit', $item->pasien_id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->pasien_id }}"
                                                        action="{{ route('pasien.destroy', $item->pasien_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->pasien_id }}').submit();">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
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
                            "<td>" + item.pasien_gender + "</td>" +
                            "<td>" + item.pasien_alamat + "</td>" +
                            "<td>" + item.pasien_agama + "</td>" +
                            "<td>" + item.pasien_status + "</td>" +
                            "<td>" + item.pasien_pekerjaan + "</td>" +
                            "<td>" + item.pasien_kewarganegaraan + "</td>" +
                            "<td><a href='javascript:void(0);' class='action-icon' onclick='edit(" + item
                            .pasien_kode + ")'>" +
                            "<i class='mdi mdi-square-edit-outline'></i></a>" +
                            "<a href='javascript:void(0)' onclick='hapus(" + item.pasien_kode +
                            ")' class='action-icon'>" +
                            "<i class='mdi mdi-delete'></i></a></td>" +
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
@endsection
