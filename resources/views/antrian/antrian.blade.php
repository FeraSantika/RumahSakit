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
                                <li class="breadcrumb-item active">Antrian</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Antrian</h4>
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
                                <div class="col-sm-7">
                                    <div class="text-sm-end"></div>
                                </div><!-- end col-->
                            </div>
                            <div class="table-responsive">
                                <table class="table table-centered w-100 dt-responsive nowrap" id="antrian">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>ID Poli</th>
                                            <th>Nama Poli</th>
                                            <th>Kode Poli</th>
                                            <th>Nomor Antrian</th>
                                            <th>Status Antrian</th>
                                            <th style="width: 350px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($poli as $item)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>{{ $item->id_poli }}</td>
                                                <td id="nama_poli">{{ $item->nama_poli }}</td>
                                                <td>{{ $item->kode_poli }}</td>
                                                <td id="nomor_antrian">
                                                    @if ($item->antrian)
                                                        {{ $item->antrian->nomor_antrian }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->antrian)
                                                        {{ $item->antrian->status_antrian }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td class="table-action">
                                                    <form action="{{ route('antrian-update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id_poli" value="{{ $item->id_poli }}">
                                                        @if ($item->antrian)
                                                            <input type="hidden" name="nomor_antrian"
                                                                value="{{ $item->antrian->nomor_antrian }}">
                                                        @else
                                                            <input type="hidden" name="nomor_antrian" value="0">
                                                        @endif
                                                        <div class="btn-group">
                                                            <button type="submit"
                                                                class="btn btn-primary mb-2">Next</button>
                                                    </form>
                                                    <form action="{{ route('antrian-updatestatus') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id_poli" value="{{ $item->id_poli }}">
                                                        <button onclick="submit()" type="submit"
                                                            class="btn btn-success mb-2">Panggil</button>
                                                    </form>
                            </div>
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
