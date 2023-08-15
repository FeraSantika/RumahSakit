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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Master Menu</a></li>
                                <li class="breadcrumb-item active">Menu</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Menu</h4>
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
                                    <a href="{{ route('menu.create') }}" class="btn btn-danger mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Menu</a>
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
                                            <th class="all" style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Name</th>
                                            <th>Link</th>
                                            <th>Category</th>
                                            <th>Menu sub</th>
                                            <th>Menu Position</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dtMenu as $item)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $item->Menu_name }}
                                                </td>
                                                <td>
                                                    {{ $item->Menu_link }}
                                                </td>
                                                <td>
                                                    {{ $item->Menu_category }}
                                                </td>
                                                <td>
                                                    {{ $item->submenu_name }}
                                                </td>
                                                <td>
                                                    {{ $item->Menu_position }}
                                                </td>
                                                <td class="table-action">
                                                    <a href="{{ route('menu.edit', $item->Menu_id) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->Menu_id }}"
                                                        action="{{ route('menu.destroy', $item->Menu_id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->Menu_id }}').submit();">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
                                                    </form>


                                                </td>
                                            </tr>
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
