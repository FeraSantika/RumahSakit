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

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Kode Pasien</th>
                                                <th scope="col">NIK</th>
                                                <th scope="col">Nama Pasien</th>
                                                <th scope="col">Tempat lahir</th>
                                                <th scope="col">Tanggal Lahir</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-pasien">
                                            @php
                                                $rowNumber = 1;
                                            @endphp
                                            @foreach ($dtpasien as $item)
                                                <tr id="{{ $item->pasien_id }}">
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
                                                    <td class="text-end">
                                                        <a href="{{ route('pasien.edit', $item->pasien_id) }}"
                                                            class="action-icon">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                        <a href="{{ route('pasien.destroy', $item->pasien_id) }}"
                                                            class="action-icon"
                                                            onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->pasien_id }}').submit();">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $item->pasien_id }}"
                                                            action="{{ route('pasien.destroy', $item->pasien_id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <a href="{{ route('detail.pasien', $item->pasien_id) }}"
                                                            class="action-icon">
                                                            <i class="uil-file-search-alt"></i>
                                                        </a>
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
                            {{ $dtpasien->links('pagination::bootstrap-4') }}
                        </div>
                        <p class="mt-2">
                            Menampilkan {{ $dtpasien->count() }} data dari {{ $dtpasien->total() }} total data.
                        </p>
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
                        resultList += "<tr id='item.pasien_id'>" +
                            "<td>" + rowNumber + "</td>" +
                            "<td>" + item.pasien_kode + "</td>" +
                            "<td>" + item.pasien_NIK + "</td>" +
                            "<td>" + item.pasien_nama + "</td>" +
                            "<td>" + item.pasien_tempat_lahir + "</td>" +
                            "<td>" + item.pasien_tgl_lahir + "</td>" +
                            "<td><a href='pasien/edit/" + item.pasien_id + "' class='action-icon'>" +
                            "<i class='mdi mdi-square-edit-outline'></i></a>" +
                            "<a href='javascript:void(0);' class='action-icon delete-pasien' data-pasien-id='" +
                            item.pasien_id + "'>" +
                            "<i class='mdi mdi-delete'></i></a>" +
                            "<a href='/admin/pasien/detail/" + item.pasien_id +
                            "' class='action-icon'>" +
                            "<i class='uil-file-search-alt'></i></a></td>" +
                            "</tr>";
                        rowNumber++;
                    });
                } else {
                    resultList = "<tr><td colspan='12'>Tidak ada hasil ditemukan.</td></tr>";
                }

                $("#data-pasien").html(resultList);

                $('.delete-pasien').on('click', function(event) {
                    event.preventDefault();

                    var pasienId = $(this).data('pasien-id');
                    console.log('Mengklik tombol hapus dengan pasienId: ' + pasienId);
                    if (confirm(
                            'Anda yakin ingin menghapus pasien ini?')) {
                        deletePasien(pasienId);
                    }
                });

                function deletePasien(pasienId, deleteButton) {
                    console.log('Mengirim permintaan DELETE untuk pasienId: ' + pasienId);
                    $.ajax({
                        url: '/admin/pasien/destroysearch/' + pasienId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Pasien deleted successfully');
                            var tr = $("#" + pasienId); 
                            if (tr.length > 0) {
                                tr.remove();
                            } else {
                                console.log('Element <tr> not found.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting pasien:', error);
                        }
                    });
                }


            }

            function resetSearchResults() {
                var searchTerm = $("#search").val();
                $("#data-pasien").empty();
            }
        });
    </script>
@endsection
