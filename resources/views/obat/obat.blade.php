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
                                <li class="breadcrumb-item active">Obat</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Obat</h4>
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
                                    <a href="{{ route('obat.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Obat</a>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <div class="text-sm-end">
                                        <div class="input-group">
                                            <input type="text" class="typeahead form-control" name="search"
                                                id="search" placeholder="Cari Obat">
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
                                            <th>Nama obat</th>
                                            <th>Kategori</th>
                                            <th>Harga Jual</th>
                                            <th>Diskon</th>
                                            <th>Stok</th>
                                            <th style="width: 95px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-obat">
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtobat as $item)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>
                                                    {{ $item->nama_obat }}
                                                </td>
                                                <td>{{ $item->kategori->nama_kategori }}</td>
                                                <td>
                                                    {{ number_format($item->harga_jual, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    {{ $item->diskon_obat }}%
                                                </td>
                                                <td>
                                                    {{ $item->stok_obat }}
                                                </td>
                                                <td class="table-action">
                                                    <a href="{{ route('obat.edit', $item->kode_obat) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->kode_obat }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->kode_obat }}"
                                                        action="{{ route('obat.destroy', $item->kode_obat) }}"
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search-btn").click(function() {
                var searchTerm = $("#search").val();
                performSearch(searchTerm);
            });

            function performSearch(searchTerm) {
                $.ajax({
                    url: "{{ route('search.obat') }}",
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
                            "<td>" + item.nama_obat + "</td>" +
                            "<td>" + item.kategori.nama_kategori + "</td>" +
                            "<td>" + item.harga_jual + "</td>" +
                            "<td>" + item.diskon_obat + "</td>" +
                            "<td>" + item.stok_obat + "</td>" +
                            "<td><a href='obat/edit/" + item.kode_obat + "' class='action-icon'>" +
                            "<i class='mdi mdi-square-edit-outline'></i></a>" +
                            "<a href='obat/destroy/" + item.kode_obat + "' class='action-icon'>" +
                            "<i class='mdi mdi-delete'></i></a></td>" +
                            "</tr>";

                        rowNumber++;
                    });
                } else {
                    resultList = "<tr><td colspan='12'>Tidak ada hasil ditemukan.</td></tr>";
                }

                $("#data-obat").html(resultList);
            }

            function resetSearchResults() {
                var searchTerm = $("#search").val();
                $("#data-obat").empty();
            }
        });
    </script>
@endsection
