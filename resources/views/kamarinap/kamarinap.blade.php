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
                                {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">Master User</a></li> --}}
                                <li class="breadcrumb-item active">Kamar Inap</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Kamar Inap</h4>
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
                                    <a href="{{ route('kamar_inap.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Kamar Inap</a>
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
                                            <th>Nama kamar</th>
                                            <th>Nomor kamar</th>
                                            <th>Harga kamar</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($kamarinap as $kamar)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>
                                                    {{ $kamar->nama_kamar_inap }}
                                                </td>

                                                <td>
                                                    {{ $kamar->nomor_kamar_inap }}
                                                </td>

                                                <td>
                                                    {{ number_format($kamar->harga_kamar_inap, 0, ',', '.') }}
                                                </td>

                                                <td class="table-action">
                                                    <a href="{{ route('kamar_inap.edit', $kamar->id_kamar_inap) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $kamar->id_kamar_inap }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $kamar->id_kamar_inap }}"
                                                        action="{{ route('kamar_inap.destroy', $kamar->id_kamar_inap) }}"
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
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection
