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
                                <li class="breadcrumb-item active">Master Rumah Sakit</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Master Rumah Sakit</h4>
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
                                    <a href="{{ route('rumah_sakit.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Data Rumah Sakit</a>
                                </div>
                                <div class="col-sm-7">
                                    <div class="text-sm-end">
                                        {{-- <button type="button" class="btn btn-success mb-2 me-1"><i
                                                class="mdi mdi-cog-outline"></i></button>
                                        <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                        <button type="button" class="btn btn-light mb-2">Export</button> --}}
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Rumah Sakit</th>
                                            <th>Logo</th>
                                            <th>Alamat</th>
                                            <th>No.Telp</th>
                                            <th>Email</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($rumahsakit as $rs)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>
                                                    {{ $rs->nama_rumahsakit }}
                                                </td>
                                                <td>
                                                    <img src="{{ asset($rs->logo_rumahsakit) }}" width="100px">
                                                </td>
                                                <td>
                                                    {{ $rs->alamat_rumahsakit }}
                                                </td>
                                                <td>
                                                    {{ $rs->telp_rumahsakit }}
                                                </td>
                                                <td>
                                                    {{ $rs->email_rumahsakit }}
                                                </td>

                                                <td class="table-action">
                                                    <a href="{{ route('rumah_sakit.edit', $rs->id_rumahsakit) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $rs->id_rumahsakit }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $rs->id_rumahsakit }}"
                                                        action="{{ route('rumah_sakit.destroy', $rs->id_rumahsakit) }}" method="POST">
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
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div>
@endsection
