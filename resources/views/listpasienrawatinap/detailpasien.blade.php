@extends('main')

@section('content')
    <style>
        .ui-autocomplete {
            z-index: 215000000 !important;
        }

        .white-input {
            background-color: white;
            color: white;
            border-color: white;
        }
    </style>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('list-daftar-pasienInap') }}">List Daftar
                                    Pasien</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('list-daftar-pasienInap') }}">List Daftar Pasien
                                    Rawat Inap</a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Detail Pasien</a></li>
                        </ol>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0);" onclick="history.back();">
                            <i class="uil-left-arrow-from-left h1"></i>
                        </a>
                        <h4 class="page-title">Detail Pasien Rawat Inap</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        @foreach ($dtpendaftar as $pendaftar)
                            <img src="{{ asset($pendaftar->pasien->pasien_jenis_kelamin === 'Laki-laki' ? 'assets/images/male.png' : 'assets/images/female.png') }}"
                                class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                            <h4 class="mb-0 mt-2">{{ $pendaftar->pasien->pasien_nama }}</h4>
                            <p class="text-muted mt-1 font-14">{{ $pendaftar->pasien->pasien_kode }}</p>
                            <input type="text" name="kode" id="kode" value="{{ $pendaftar->kode_pendaftaran }}"
                                hidden>

                            <div class="text-start mt-3">
                                <h4 class="font-13 text-uppercase">Tentang saya :</h4>
                                <p class="text-muted font-13 mb-3">
                                    Hi saya {{ $pendaftar->pasien->pasien_nama }}, salah satu pasien Anda
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>NIK :</strong> <span class="ms-2">
                                        {{ $pendaftar->pasien->pasien_NIK }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Nama :</strong> <span class="ms-2">
                                        {{ $pendaftar->pasien->pasien_nama }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Status Pasien :</strong>
                                    @if ($pendaftar->status_pasien === 'Umum')
                                        <span class="badge bg-success">{{ $pendaftar->status_pasien }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $pendaftar->status_pasien }}</span>
                                    @endif
                                </p>

                                <p class="text-muted mb-2 font-13"><strong>Tempat, tanggal lahir :</strong><span
                                        class="ms-2">
                                        {{ $pendaftar->pasien->pasien_tempat_lahir }},
                                        {{ $pendaftar->pasien->pasien_tgl_lahir }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Jenis kelamin :</strong> <span
                                        class="ms-2 ">{{ $pendaftar->pasien->pasien_jenis_kelamin }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Kewarganegaraan :</strong> <span
                                        class="ms-2 ">{{ $pendaftar->pasien->pasien_kewarganegaraan }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Alamat :</strong> <span
                                        class="ms-2">{{ $pendaftar->pasien->pasien_alamat }}</span>
                                </p>

                                <p class="text-muted mb-2 font-13"><strong>Pekerjaan :</strong> <span
                                        class="ms-2 ">{{ $pendaftar->pasien->pasien_pekerjaan }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Status Perkawinan :</strong> <span
                                        class="ms-2 ">{{ $pendaftar->pasien->pasien_status }}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Agama :</strong> <span
                                        class="ms-2 ">{{ $pendaftar->pasien->pasien_agama }}</span></p>
                        @endforeach
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <!-- Riwayat Pemeriksaan-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Riwayat pemeriksaan</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div class="inbox-widget">
                        <div class="inbox-item">
                            @foreach ($dtriwayat as $item)
                                <div class="inbox-item">
                                    <div class="inbox-item-img">
                                        <img src="{{ asset('assets/images/riwayat.png') }}" class="rounded-circle"
                                            alt="">
                                    </div>
                                    <p class="inbox-item-author">{{ $item->kode_pendaftaran }}</p>
                                    <p class="inbox-item-text"> {{ $item->created_at }}</p>
                                    <p class="inbox-item-date">
                                        <a href="#" class="btn btn-sm btn-link text-info font-13"
                                            data-bs-toggle="modal"
                                            data-bs-target="#primary-header-modal-{{ $item->kode_pendaftaran }}">
                                            Detail
                                        </a>
                                    </p>
                                </div>

                                {{-- Modal --}}
                                <div id="primary-header-modal-{{ $item->kode_pendaftaran }}" class="modal fade"
                                    tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h4 class="modal-title text-white" id="standard-modalLabel">Detail
                                                    Riwayat Pemeriksaan</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label><b>Kode Pendaftaran:</b></label>
                                                <p>{{ $item->kode_pendaftaran }}</p>
                                                <hr>
                                                <label><b>Tanggal:</b></label>
                                                <p>{{ $item->created_at }}</p>
                                                <hr>
                                                {{-- <label><b>Poli:</b></label>
                                                <p>{{ $item->poli->nama_poli }}</p>
                                                <hr> --}}
                                                <label><b>Dokter:</b></label>
                                                <p>
                                                    {{ $item->user->User_name }}
                                                </p>
                                                <hr>
                                                <label><b>Diagnosa:</b></label>
                                                <p>{{ $item->diagnosa }}</p>
                                                <h5>List Daftar Obat</h5>
                                                <div class="row mb-2">
                                                    <div class="table-responsive">
                                                        <table class="table table-centered dt-responsive">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 50px">Nama Obat</th>
                                                                    <th style="width: 50px">Kategori Obat</th>
                                                                    <th style="width: 50px">Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="obatList">
                                                                <tr id="row">
                                                                    <td>{{ $item->listobat->nama_obat }}
                                                                    </td>
                                                                    <td>{{ $item->listobat->kategori_obat }}
                                                                    </td>
                                                                    <td>{{ $item->listobat->qty }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <h5>List Daftar Tindakan</h5>
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table class="table table-centered w-30 ">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tindakanList">
                                                                <tr id="row">
                                                                    <td>{{ $item->listtindakan->nama_tindakan }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            @endforeach
                        </div>
                    </div> <!-- end inbox-widget -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        {{-- Tab kanan --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3" id="tab-navigasi">
                        <li class="nav-item">
                            <a href="#kamar" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Kamar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#diagnosa" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Diagnosa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#obat" data-bs-toggle="tab" aria-expanded="true"
                                class="nav-link rounded-0 active">
                                Obat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tindakan" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Tindakan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#rujukan" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Rujukan
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mb-3">
                        {{-- tab-pane kamar inap --}}
                        <div class="tab-pane" id="kamar">
                            @foreach ($dtpendaftar as $pendaftar)
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-danger mb-2" data-bs-toggle="modal"
                                        data-bs-target="#kamarinap-modal"><i class="mdi mdi-plus-circle me-2"></i>
                                        Add Kamar
                                    </a>
                                </div>

                                {{-- Modal Kamar Inap --}}
                                <div id="kamarinap-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h4 class="modal-title text-white" id="standard-modalLabel">
                                                    Pilih Kamar Inap
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12 align-center">
                                                    <form action="" method="POST" class="mb-3">
                                                        @csrf
                                                        <div class="row">
                                                            <input type="text"
                                                                value="{{ $pendaftar->kode_pendaftaran }}" name="kode"
                                                                id="kodedaftar" hidden>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="tglmasuk" class="form-label">Tanggal
                                                                    Masuk</label>
                                                                <input type="date" name="tglmasuk" id="tglmasuk"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="tglkeluar" class="form-label">Perkiraan
                                                                    Tanggal
                                                                    Keluar</label>
                                                                <input type="date" name="perkiraankeluar"
                                                                    id="perkiraankeluar" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="search" class="form-label-md-6">Pilih
                                                                    Kamar</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="typeahead form-control"
                                                                        name="search" id="search-kamar"
                                                                        placeholder="Cari Kamar">
                                                                    <button class="input-group-text btn btn-primary btn-sm"
                                                                        type="button" id="add-kamar">
                                                                        <i class="ri-add-box-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <input type="text" name="id" id="idkamar"
                                                                class="form-control" hidden>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="nama" class="form-label-md-6">Nama
                                                                    Kamar</label>
                                                                <input type="text" name="nama" id="nama"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="nomor" class="form-label-md-6">Nomor
                                                                    Kamar</label>
                                                                <input type="text" name="nomor" id="nomor"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" id="submit-kamar"
                                                    type="submit">Tambah</button>
                                            </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal Kamar Inap -->

                                <div class="row mb-5">
                                    <div class="table-responsive">
                                        <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Nama Kamar</th>
                                                    <th>Nomor Kamar</th>
                                                    <th>Tanggal Keluar</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="kamarList">
                                                @foreach ($dtkamarpasien as $kamar)
                                                    <tr id="kamar-{{ $kamar->id_kamar_pasieninap }}">
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($kamar->tanggal_masuk)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $kamar->kamar->nama_kamar_inap }}</td>
                                                        <td class="text-center">{{ $kamar->kamar->nomor_kamar_inap }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($kamar->tanggal_keluar)->format('d/m/Y') }}
                                                        </td>
                                                        <td>
                                                            <a href="#" class="kamar"
                                                                data-id="{{ $kamar->id_kamar_pasieninap }}"
                                                                data-tglmasuk="{{ $kamar->tanggal_masuk }}"
                                                                data-tglkeluar="{{ $kamar->tanggal_keluar }}"
                                                                data-namakamar="{{ $kamar->kamar->nama_kamar_inap }}"
                                                                data-nomorkamar="{{ $kamar->kamar->nomor_kamar_inap }}">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="action-icon"
                                                                onclick="hapuskamar('{{ $kamar->id_kamar_pasieninap }}')">
                                                                <i class="mdi mdi-delete"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    {{-- @php
                                                        $rowNumber++;
                                                    @endphp --}}
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Modal Edit Kamar Inap --}}
                                <div id="editkamarinap-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h4 class="modal-title text-white" id="standard-modalLabel">
                                                    Edit Kamar Inap
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12 align-center">
                                                    <form action="" method="POST" class="mb-3">
                                                        @csrf
                                                        <div class="row">
                                                            <input type="text"
                                                                value="{{ $pendaftar->kode_pendaftaran }}" name="kode"
                                                                id="kodedaftar" hidden>
                                                            <input type="text" name="id_kamar_pasieninap"
                                                                id="edit-id_kamar_pasieninap"
                                                                value="{{ isset($kamar->id_kamar_pasieninap) ? $kamar->id_kamar_pasieninap : '' }}"
                                                                class="form-control white-input">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="tglmasuk" class="form-label">Tanggal
                                                                    Masuk</label>
                                                                <input type="date" name="tglmasuk" id="edittglmasuk"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="tglkeluar" class="form-label">Perkiraan
                                                                    Tanggal
                                                                    Keluar</label>
                                                                <input type="date" name="perkiraankeluar"
                                                                    id="editperkiraankeluar" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="search" class="form-label-md-6">Pilih
                                                                    Kamar</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="typeahead form-control"
                                                                        name="search" id="search-editkamar"
                                                                        placeholder="Cari Kamar">
                                                                    <button class="input-group-text btn btn-primary btn-sm"
                                                                        type="button" id="add-kamar">
                                                                        <i class="ri-add-box-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <input type="text" name="id" id="editidkamar"
                                                                class="form-control white-input">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="nama" class="form-label-md-6">Nama
                                                                    Kamar</label>
                                                                <input type="text" name="nama" id="editnama"
                                                                    class="form-control" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="nomor" class="form-label-md-6">Nomor
                                                                    Kamar</label>
                                                                <input type="text" name="nomor" id="editnomor"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" id="submit-editkamar"
                                                    type="submit">Simpan Perubahan</button>
                                            </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal Edit Kamar Inap -->
                            @endforeach
                        </div>
                        {{-- end tab-pane kamar inap --}}
                        {{-- tab-pane diagnosa --}}
                        <div class="tab-pane" id="diagnosa">
                            @foreach ($dtpendaftar as $pendaftar)
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-danger mb-2" data-bs-toggle="modal"
                                        data-bs-target="#diagnosa-modal" id="open-diagnosa-modal"><i
                                            class="mdi mdi-plus-circle me-2"></i>
                                        Add Diagnosa
                                    </a>
                                </div>

                                {{-- Modal --}}
                                <div id="diagnosa-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h4 class="modal-title text-white" id="standard-modalLabel">
                                                    Tambahkan Diagnosa Pasien
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12 align-center">
                                                    <form action="{{ route('listdaftardiagnosa_pasienInap.insert') }}"
                                                        method="POST" class="mb-3">
                                                        @csrf
                                                        <div class="row">
                                                            <input type="text"
                                                                value="{{ $pendaftar->kode_pendaftaran }}" name="kode"
                                                                id="kodedaftar" hidden>
                                                            <div class="col mb-3">
                                                                <label for="tgldiagnosa" class="form-label">Tanggal
                                                                    Diagnosa</label>
                                                                <input type="date" name="tgldiagnosa" id="tgldiagnosa"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <textarea rows="3" name="diagnosa" id="diagnosapasien" class="form-control border-1 resize-none"
                                                            placeholder="Diagnosa ...."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" id="submit-diagnosa"
                                                    type="submit">Tambah</button>
                                            </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                                <div class="row mb-5">
                                    <div class="table-responsive">
                                        <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal Diagnosa</th>
                                                    <th>Diagnosa</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="diagnosaList">
                                                @foreach ($dtdiagnosa as $diagnosa)
                                                    <tr id="diagnosa-{{ $diagnosa->id_diagnosa_pasieninap }}">
                                                        <td>{{ \Carbon\Carbon::parse($diagnosa->tanggal)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $diagnosa->diagnosa }}</td>
                                                        <td>
                                                            <a href="#" class="diagnosa" data-bs-toggle="modal"
                                                                data-bs-target="#editdiagnosa-modal"
                                                                data-id="{{ $diagnosa->id_diagnosa_pasieninap }}"
                                                                data-tgldiagnosa="{{ $diagnosa->tanggal }}"
                                                                data-diagnosa="{{ $diagnosa->diagnosa }}"
                                                                id="open-diagnosa-modal"><i
                                                                    class="mdi mdi-square-edit-outline"></i></a>
                                                            <a href="javascript:void(0);" class="action-icon"
                                                                onclick="hapusdiagnosa('{{ $diagnosa->id_diagnosa_pasieninap }}')">
                                                                <i class="mdi mdi-delete"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Modal Edit Diagnosa Pasien --}}
                                <div id="editdiagnosa-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h4 class="modal-title text-white" id="standard-modalLabel">
                                                    Edit Diagnosa Pasien
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            </div>
                                            <form action="{{ route('listdaftardiagnosa_pasienInap.update') }}"
                                                method="POST" class="mb-3">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-md-12 align-center">
                                                        <div class="row">
                                                            <input type="text"
                                                                value="{{ $pendaftar->kode_pendaftaran }}" name="kode"
                                                                id="kodedaftar" hidden>
                                                            <input type="text" id="edit-diagnosa-id"
                                                                name="edit-diagnosa-id" class="form-control white-input">
                                                            <div class="col mb-3">
                                                                <label for="tgldiagnosa" class="form-label">Tanggal
                                                                    Diagnosa</label>
                                                                <input type="date" name="tgldiagnosa"
                                                                    id="edittgldiagnosa" class="form-control">
                                                            </div>
                                                        </div>
                                                        <textarea rows="3" name="diagnosa" id="editdiagnosapasien" class="form-control border-1 resize-none"
                                                            placeholder="Diagnosa ....">{{ isset($editdiagnosa) ? $editdiagnosa->diagnosa : '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" id="submit-editdiagnosa"
                                                        type="submit">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- /Modal Edit Diagnosa Pasien -->
                            @endforeach
                        </div> <!-- end tab-pane -->
                        {{-- tab-pane obat --}}
                        <div class="tab-pane show active" id="obat">
                            @foreach ($dtpendaftar as $pendaftar)
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-danger mb-2" data-bs-toggle="modal"
                                        data-bs-target="#obat-modal"><i class="mdi mdi-plus-circle me-2"></i>
                                        Add Obat
                                    </a>
                                </div>

                                <div id="obat-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="obatForm" action="{{ route('detail.insertobatpasien') }}"
                                                method="POST" class="mb-3">
                                                @csrf
                                                <div class="modal-header bg-primary">
                                                    <h4 class="modal-title text-white" id="standard-modalLabel">
                                                        Pilih Obat Pasien
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12 align-center">
                                                        <div class="row">
                                                            <input type="text"
                                                                value="{{ $pendaftar->kode_pendaftaran }}" name="kode"
                                                                id="kodedaftar" hidden>
                                                            <div class="col mb-3">
                                                                <label for="tglobat" class="form-label">Tanggal</label>
                                                                {{ csrf_field() }}
                                                                <input type="date" name="tglobat" id="tglobat"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="search" class="form-label">Pilih
                                                                    Obat</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    {{ csrf_field() }}
                                                                    <input type="text" class="typeahead form-control"
                                                                        name="search" id="search-obat"
                                                                        placeholder="Cari Obat">
                                                                    <button class="input-group-text btn btn-primary btn-sm"
                                                                        type="button" id="add-obat"><i
                                                                            class="ri-add-box-line"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mt-3 text-center">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" id="submit-obat"
                                                        type="submit">Tambah</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>

                                <div class="row mb-5">
                                    <div class="table-responsive">
                                        <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                            <thead class="table-light">
                                                <tr>
                                                    {{-- <th>No.</th> --}}
                                                    <th>Tanggal</th>
                                                    <th>Nama Obat</th>
                                                    <th>Kategori Obat</th>
                                                    <th>Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="obatList">
                                                @php
                                                    $rowNumber = 1;
                                                @endphp
                                                @foreach ($dtlistobat as $obat)
                                                    <tr id="row-{{ $obat->list_id }}">
                                                        {{-- <td>{{ $rowNumber }}</td> --}}
                                                        <td>{{ \Carbon\Carbon::parse($obat->tanggal)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $obat->nama_obat }}</td>
                                                        <td>{{ $obat->kategori_obat }}</td>
                                                        <td>
                                                            <input type="text" name="qty"
                                                                id="qty-{{ $obat->list_id }}"
                                                                value="{{ $obat->qty }}" class="form-control"
                                                                style="max-width: 100px;">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0);" class="action-icon"
                                                                onclick="edit('{{ $obat->list_id }}')">
                                                                <i class="mdi mdi-square-edit-outline"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="action-icon"
                                                                onclick="hapusobat('{{ $obat->list_id }}')">
                                                                <i class="mdi mdi-delete"></i>
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
                            @endforeach
                        </div>
                        {{-- end tab-pane obat --}}
                        {{-- tab-pane tindakan --}}
                        <div class="tab-pane" id="tindakan">
                            @foreach ($dtpendaftar as $pendaftar)
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-danger mb-2" data-bs-toggle="modal"
                                        data-bs-target="#tindakan-modal"><i class="mdi mdi-plus-circle me-2"></i>
                                        Add Tindakan
                                    </a>
                                </div>

                                {{-- Modal Tindakan --}}
                                <div id="tindakan-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('listdaftartindakan_pasienInap.insert') }}"
                                                method="POST" class="mb-3">
                                                @csrf
                                                <div class="modal-header bg-primary">
                                                    <h4 class="modal-title text-white" id="standard-modalLabel">
                                                        Pilih Tindakan Pasien
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12 align-center">

                                                        <div class="row">
                                                            <input type="text"
                                                                value="{{ $pendaftar->kode_pendaftaran }}" name="kode"
                                                                id="kodedaftar" hidden>
                                                            <div class="col mb-3">
                                                                <label for="tgltindakan"
                                                                    class="form-label">Tanggal</label>
                                                                {{ csrf_field() }}
                                                                <input type="date" name="tgltindakan" id="tgltindakan"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="search" class="form-label-md-6">Pilih
                                                                    Tindakan</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="typeahead form-control"
                                                                        name="search" id="search-tindakan"
                                                                        placeholder="Cari Tindakan">
                                                                    <button class="input-group-text btn btn-primary btn-sm"
                                                                        type="button" id="add-tindakan"><i
                                                                            class="ri-add-box-line"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" id="submit-tindakan"
                                                        type="submit">Tambah</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal obat -->


                                <div class="row mb-5">
                                    <div class="table-responsive">
                                        <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Tindakan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tindakanList">
                                                @foreach ($dtlisttindakan as $tindakan)
                                                    <tr id="row-{{ $tindakan->list_id }}">
                                                        <td>{{ \Carbon\Carbon::parse($tindakan->tanggal)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $tindakan->nama_tindakan }}</td>
                                                        <td>
                                                            <a href="#" class="tindakan" data-bs-toggle="modal"
                                                                data-bs-target="#edittindakan-modal"
                                                                data-id="{{ $tindakan->list_id }}"
                                                                data-tgltindakan="{{ $tindakan->tanggal }}"
                                                                data-tindakan="{{ $tindakan->nama_tindakan }}"
                                                                id="open-edittindakan-modal">
                                                                <i class="mdi mdi-square-edit-outline"></i></a>
                                                            <a href="javascript:void(0);" class="action-icon"
                                                                onclick="hapustindakan('{{ $tindakan->list_id }}')">
                                                                <i class="mdi mdi-delete"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Modal Edit Tindakan Pasien --}}
                                <div id="edittindakan-modal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h4 class="modal-title text-white" id="standard-modalLabel">
                                                    Edit Tindakan Pasien
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            </div>
                                            <form action="{{ route('listdaftartindakan_pasienInap.update') }}"
                                                method="POST" class="mb-3">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="col-md-12 align-center">
                                                        <div class="row">
                                                            <input type="text"
                                                                value="{{ $pendaftar->kode_pendaftaran }}" name="kode"
                                                                id="kodedaftar" hidden>
                                                            <input type="text" id="edit-tindakan-id"
                                                                name="edit-tindakan-id" class="form-control white-input">
                                                            <div class="col mb-3">
                                                                <label for="editgltindakan" class="form-label">Tanggal
                                                                    Tindakan</label>
                                                                <input type="date" name="edittgltindakan"
                                                                    id="edittgltindakan" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-3">
                                                                <label for="search" class="form-label-md-6">Pilih
                                                                    Tindakan</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="typeahead form-control"
                                                                        name="search" id="search-edittindakan"
                                                                        placeholder="Cari Tindakan">
                                                                    <button class="input-group-text btn btn-primary btn-sm"
                                                                        type="button" id="add-edittindakan"><i
                                                                            class="ri-add-box-line"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" id="submit-edittindakan"
                                                        type="submit">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- /Modal Edit Tindakan Pasien -->
                            @endforeach
                        </div>
                        {{-- end tab-pane tindakan --}}
                        {{-- tab-pane rujukan --}}
                        <div class="tab-pane" id="rujukan">
                            <!-- comment box -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-end mb-3">
                                        <div class="input-group">
                                            <input type="text" class="typeahead form-control" name="search"
                                                id="search-rujukan" placeholder="Cari Rujukan" data-selected-id="">
                                            <button class="input-group-text btn btn-primary btn-sm" type="button"
                                                id="add-rujukan"><i class="ri-add-box-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="table-responsive">
                                    <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Rujukan</th>
                                                <th>Keterangan</th>
                                                <th>File</th>
                                                <th>Status Rujukan</th>
                                                @if (!empty($rujukan) && $rujukan->status == 'Belum tertangani')
                                                    <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody id="rujukanList">
                                            @foreach ($dtlistrujukan as $rujukan)
                                                <tr id="row-{{ $rujukan->list_id }}">
                                                    <td>
                                                        @if ($rujukan->lab)
                                                            {{ $rujukan->lab->nama_lab }}
                                                        @else
                                                            Data Lab Tidak Tersedia
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($rujukan->keterangan == null)
                                                            Belum ada keterangan
                                                        @else
                                                            {{ $rujukan->keterangan }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($rujukan->filerujukan == null)
                                                            Belum ada file
                                                        @else
                                                            <a href="{{ asset('uploads/' . $rujukan->filerujukan) }}"
                                                                download><i class="uil-download-alt h3"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $rujukan->status }}</td>
                                                    @if (!empty($rujukan) && $rujukan->status == 'Belum tertangani')
                                                        <td>
                                                            <a href="javascript:void(0);" class="action-icon"
                                                                onclick="hapusrujukan('{{ $rujukan->list_id }}')">
                                                                <i class="mdi mdi-delete"></i>
                                                            </a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>{{-- end tab-pane rujukan --}}

                    </div>
                    <!-- end .border-->
                    <div class="align-center" style="display: flex; justify-content: center;">
                        <button type="button" id="pemeriksaan-selesai" class="btn btn-primary">Pemeriksaan
                            Selesai</button>
                    </div>
                    <!-- end comment box -->
                </div>
                <!-- end obat content-->
                <!-- end tindakan content-->
            </div> <!-- end tab-content -->
        </div> <!-- end card body -->
    </div> <!-- end card -->
    </div> <!-- end col -->
    </div>
    <!-- end row-->
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Temukan elemen tab Diagnosa berdasarkan ID
            var diagnosaTabEl = document.querySelector('a[href="#diagnosa"]');

            // Aktifkan tab Diagnosa
            var diagnosaTab = new bootstrap.Tab(diagnosaTabEl);
            diagnosaTab.show();
        });

        // Mencari data DataKamarInap pada modal Add Kamar
        $(document).ready(function() {
            var path = "{{ route('autocomplete_kamar_pasienInap') }}";
            $("#search-kamar").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.nama + ' - ' + item.nomor,
                                    value: item.id,
                                    nama_kamar: item.nama,
                                    nomor_kamar: item.nomor,
                                };
                                console.log(item);
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search-kamar').val(ui.item.nama_kamar + ' - ' + ui.item.nomor_kamar);
                    $('#nama').val(ui.item.nama_kamar);
                    $('#nomor').val(ui.item.nomor_kamar);
                    $('#idkamar').val(ui.item.value);

                    var idKamarInap = ui.item.value;
                    console.log('id kamar' + idKamarInap);
                    return false;
                }
            });
        });

        // Mencari data DataKamarInap pada modal Edit Kamar
        $(document).ready(function() {
            var path = "{{ route('autocomplete_kamar_pasienInap') }}";
            $("#search-editkamar").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.nama + ' - ' + item.nomor,
                                    value: item.id,
                                    nama_kamar: item.nama,
                                    nomor_kamar: item.nomor,
                                };
                                console.log(item);
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search-editkamar').val(ui.item.nama_kamar + ' - ' + ui.item.nomor_kamar);
                    $('#editnama').val(ui.item.nama_kamar);
                    $('#editnomor').val(ui.item.nomor_kamar);
                    $('#editidkamar').val(ui.item.value);

                    var idKamarInap = ui.item.value;
                    console.log('id kamar' + idKamarInap);
                    return false;
                }
            });
        });

        // MENAMBAHKAN Data KamarPasienInap
        $('#submit-kamar').click(function(e) {
            e.preventDefault();
            let kode = $('#kodedaftar').val();
            let idkamar = $('#idkamar').val();
            let tglmasuk = $('#tglmasuk').val();
            let perkiraankeluar = $('#perkiraankeluar').val();
            let token = $("meta[name='csrf-token']").attr("content");
            var simpan = "{{ route('detail.insertkamarpasien') }}";

            $.ajax({
                url: simpan,
                type: "POST",
                cache: false,
                data: {
                    "kode": kode,
                    "id": idkamar,
                    "tglmasuk": tglmasuk,
                    "perkiraankeluar": perkiraankeluar,
                    "_token": token
                },
                success: function(response) {
                    if (response.error) {
                        swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'data sudah terdaftar. Mohon gunakan data lain.',
                            showConfirmButton: true,
                        });
                    } else {
                        var formattedDate = new Date(response.data.tanggal_masuk);
                        var day = formattedDate.getDate();
                        var month = formattedDate.getMonth() + 1;
                        var year = formattedDate.getFullYear();
                        var formattedTglMasuk =
                            `${day.toString().padStart(2, '0')}/${month.toString().padStart(2, '0')}/${year}`;

                        var formattedDate = new Date(response.data.tanggal_keluar);
                        var day = formattedDate.getDate();
                        var month = formattedDate.getMonth() + 1;
                        var year = formattedDate.getFullYear();
                        var formattedTglKeluar =
                            `${day.toString().padStart(2, '0')}/${month.toString().padStart(2, '0')}/${year}`;

                        var newRow = `
                    <tr id="kamar-${response.data.id_kamar_pasieninap}">
                        <td>${formattedTglMasuk}</td>
                        <td>${response.data.kamar.nama_kamar_inap}</td>
                        <td class="text-center">${response.data.kamar.nomor_kamar_inap}</td>
                        <td>${formattedTglKeluar}</td>
                        <td>
                            <a href="#" class="kamar"
                                data-id="${response.data.id_kamar_pasieninap}"
                                data-tglmasuk="${response.data.tanggal_masuk}"
                                data-tglkeluar="${response.data.tanggal_keluar}"
                                data-idkamar="${response.data.id_kamar_inap}"
                                data-namakamar="${response.data.kamar.nama_kamar_inap}"
                                data-nomorkamar="${response.data.kamar.nomor_kamar_inap}">
                                <i class="mdi mdi-square-edit-outline"></i>
                            </a>
                            <a href="javascript:void(0);" class="action-icon"
                                onclick="hapuskamar('${response.data.id_kamar_pasieninap}')">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </td>
                    </tr>
                `;

                        $('#kamarList').append(newRow);
                        swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil disimpan.',
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(function() {
                            console.log('Nama Kamar Inap yang baru tersimpan:', response.data
                                .kamar.nama_kamar_inap);
                            $('#kamarinap-modal').modal('hide');
                            // window.location.reload();
                        });
                    }
                    console.log(response.data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Mengirimkan data kedalam modal edit kamar
        $(document).ready(function() {
            function updateSearchInput(nama, nomor) {
                $("#search-editkamar").val(nama + " - " + nomor);
            }
            $(document).on('click', '.kamar', function() {
                var ids = $(this).data('id');
                var idkamar = $(this).data('idkamar');
                var tglmasuk = $(this).data('tglmasuk');
                var tglkeluar = $(this).data('tglkeluar');
                var nama = $(this).data('namakamar');
                var nomor = $(this).data('nomorkamar');
                $("#edit-id_kamar_pasieninap").val(ids);
                $("#editidkamar").val(idkamar);
                $("#edittglmasuk").val(tglmasuk);
                $("#editperkiraankeluar").val(tglkeluar);
                $("#editnama").val(nama);
                $("#editnomor").val(nomor);

                updateSearchInput(nama, nomor);

                $('#editkamarinap-modal').modal('show');
                console.log(ids);
            });
        });

        // MENGUBAH Data KamarPasienInap
        var url = "{{ route('detail.updatekamarpasien') }}";
        $(document).ready(function() {
            $("#submit-editkamar").click(function(e) {
                e.preventDefault();

                var url = "{{ route('detail.updatekamarpasien') }}";
                var kode = $('#kodedaftar').val();
                var idkamar = $('#editidkamar').val();
                var id = $('#edit-id_kamar_pasieninap').val();
                var tglmasuk = $('#edittglmasuk').val();
                var perkiraankeluar = $('#editperkiraankeluar').val();
                var token = $("meta[name='csrf-token']").attr("content");

                var newData = {
                    "kode": kode,
                    "idkamar": idkamar,
                    "id": id,
                    "tglmasuk": tglmasuk,
                    "perkiraankeluar": perkiraankeluar,
                    "_token": token
                };

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: newData,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Mengubah format tanggal masuk
                            var formattedDateMasuk = new Date(response.data.tanggal_masuk);
                            var dayMasuk = formattedDateMasuk.getDate();
                            var monthMasuk = formattedDateMasuk.getMonth() + 1;
                            var yearMasuk = formattedDateMasuk.getFullYear();
                            var formattedTglMasuk =
                                `${dayMasuk.toString().padStart(2, '0')}/${monthMasuk.toString().padStart(2, '0')}/${yearMasuk}`;

                            // Mengubah format tanggal keluar
                            var formattedDateKeluar = new Date(response.data.tanggal_keluar);
                            var dayKeluar = formattedDateKeluar.getDate();
                            var monthKeluar = formattedDateKeluar.getMonth() + 1;
                            var yearKeluar = formattedDateKeluar.getFullYear();
                            var formattedTglKeluar =
                                `${dayKeluar.toString().padStart(2, '0')}/${monthKeluar.toString().padStart(2, '0')}/${yearKeluar}`;

                            // Memperbarui data pada tabel secara otomatis
                            var $tableRow = $(`#kamar-${response.data.id_kamar_pasieninap}`);
                            if ($tableRow.length) {
                                $tableRow.find('td:eq(0)').text(formattedTglMasuk);
                                $tableRow.find('td:eq(1)').text(response.data.kamar
                                    .nama_kamar);
                                $tableRow.find('td:eq(2)').text(response.data.kamar
                                    .nomor_kamar_inap);
                                $tableRow.find('td:eq(3)').text(formattedTglKeluar);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil disimpan',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $("#editkamarinap-modal").modal("hide");
                            console.log("Respons dari server:", response.data);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan saat menyimpan data',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan data',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
                return false;
            });
        });

        // Menghapus Data KamarPasienInap
        function hapuskamar(id) {
            var url = "{{ route('detail.destroykamarpasien', ':list_id') }}";
            url = url.replace(':list_id', id);
            Swal.fire({
                title: "Yakin ingin menghapus data ini?",
                text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log("berhasil hapus data");
                            $("#kamar-" + id).remove();
                        }
                    })
                }
            })
        }

        var simpan = "{{ route('listdaftardiagnosa_pasienInap.insert') }}";
        $('#submit-diagnosa').click(function(e) {
            e.preventDefault();
            let kode = $('#kodedaftar').val();
            let tgldiagnosa = $('#tgldiagnosa').val();
            let diagnosa = $('#diagnosapasien').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: simpan,
                type: "POST",
                cache: false,
                data: {
                    "kode": kode,
                    "tgldiagnosa": tgldiagnosa,
                    "diagnosa": diagnosa,
                    "_token": token
                },
                success: function(response) {
                    if (response.error) {
                        swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'data sudah terdaftar. Mohon gunakan data lain.',
                            showConfirmButton: true,
                        });
                    } else {
                        var formattedDate = new Date(response.data.tanggal);
                        var day = formattedDate.getDate();
                        var month = formattedDate.getMonth() + 1;
                        var year = formattedDate.getFullYear();
                        var formattedTgl =
                            `${day.toString().padStart(2, '0')}/${month.toString().padStart(2, '0')}/${year}`;

                        var newRow = `
                    <tr id="diagnosa-${response.data.id_diagnosa_pasieninap}">
                        <td>${formattedTgl}</td>
                        <td>${response.data.diagnosa}</td>
                        <td>
                            <a href="#" class="diagnosa"
                                data-id="${response.data.id_diagnosa_pasieninap}"
                                data-tgldiagnosa="${response.data.tanggal}"
                                data-diagnosa="${response.data.diagnosa}">
                                <i class="mdi mdi-square-edit-outline"></i>
                            </a>
                            <a href="javascript:void(0);" class="action-icon"
                                onclick="hapusdiagnosa('${response.data.id_diagnosa_pasieninap}')">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </td>
                    </tr>
                `;

                        $('#diagnosaList').append(newRow);
                        swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil disimpan.',
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(function() {
                            console.log('Diagnosa yang baru tersimpan:', response.data
                                .diagnosa);
                            $('#diagnosa-modal').modal('hide');
                            // window.location.reload();
                        });
                    }
                    console.log(response.data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Mengirimkan data kedalam modal edit diagnosa
        $(document).on('click', '.diagnosa', function() {
            var diagnosaId = $(this).data('id');
            var tgldiagnosa = $(this).data('tgldiagnosa');
            var diagnosa = $(this).data('diagnosa');
            $('#edit-diagnosa-id').val(diagnosaId);
            $('#edittgldiagnosa').val(tgldiagnosa);
            $('#editdiagnosapasien').val(diagnosa);
            $('#editdiagnosa-modal').modal('show');
        });


        $(document).ready(function() {
            $("#submit-editdiagnosa").click(function(e) {
                e.preventDefault();

                var url = "{{ route('listdaftardiagnosa_pasienInap.update') }}";
                var kode = $('#kodedaftar').val();
                var id = $('#edit-diagnosa-id').val();
                var tgldiagnosa = $('#edittgldiagnosa').val();
                var diagnosa = $('#editdiagnosapasien').val();
                var token = $("meta[name='csrf-token']").attr("content");

                var newData = {
                    "kode": kode,
                    "id": id,
                    "tgldiagnosa": tgldiagnosa,
                    "diagnosa": diagnosa,
                    "_token": token
                };

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    data: newData,
                    success: handleSuccess,
                    error: handleError
                });

                return false;
            });
        });

        function handleSuccess(response) {
            if (response.success) {
                var formattedDateMasuk = new Date(response.data.tanggal);
                var dayMasuk = formattedDateMasuk.getDate();
                var monthMasuk = formattedDateMasuk.getMonth() + 1;
                var yearMasuk = formattedDateMasuk.getFullYear();
                var formattedTgl =
                    `${dayMasuk.toString().padStart(2, '0')}/${monthMasuk.toString().padStart(2, '0')}/${yearMasuk}`;

                var $tableRow = $(`#diagnosa-${response.data.id_diagnosa_pasieninap}`);
                if ($tableRow.length) {
                    $tableRow.find('td:eq(0)').text(formattedTgl);
                    $tableRow.find('td:eq(1)').text(response.data.diagnosa);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil diperbarui',
                    showConfirmButton: false,
                    timer: 1500
                });

                $("#editdiagnosa-modal").modal("hide");
            } else {
                handleError(); // Menampilkan pesan kesalahan dari server
            }
        }

        function handleError() {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan saat memproses permintaan',
                showConfirmButton: false,
                timer: 1500
            });
        }


        // Menghapus Data DiagnosaPasienInap
        function hapusdiagnosa(id) {
            var url = "{{ route('detail.destroydiagnosapasien', ':list_id') }}";
            url = url.replace(':list_id', id);
            Swal.fire({
                title: "Yakin ingin menghapus data ini?",
                text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log("berhasil hapus data");
                            $("#diagnosa-" + id).remove();
                        }
                    })
                }
            })
        }

        // Mencari data obat didalam modal Add Obat
        $(document).ready(function() {
            var path = "{{ route('autocomplete_obat_pasienInap') }}";
            $("#search-obat").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search-obat').val(ui.item.label);
                    console.log(ui.item);
                    return false;
                }
            });
        });

        //Menambahkan list obat kedalam tabel ListDaftarObatPasienInap
        var insertlist = "{{ route('detail.insertobatpasien') }}";
        $("#submit-obat").click(function() {
            var search = $("#search-obat").val();
            var kode = $("#kodedaftar").val();
            var tgl = $("#tglobat").val();
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: insertlist,
                type: "POST",
                cache: false,
                data: {
                    "search": search,
                    "kode": kode,
                    "tglobat": tgl,
                    "_token": token
                },
                success: function(response) {
                    if (response.success) {
                        // Mengubah format tanggal
                        var formattedDate = new Date(response.data.tanggal);
                        var day = formattedDate.getDate();
                        var month = formattedDate.getMonth() + 1;
                        var year = formattedDate.getFullYear();
                        var formattedDateString =
                            `${day.toString().padStart(2, '0')}/${month.toString().padStart(2, '0')}/${year}`;

                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        var newRow = `
                    <tr id="row-${response.data.list_id}">
                        <td class="tanggal-cell">${formattedDateString}</td>
                        <td>${response.data.nama_obat}</td>
                        <td>${response.data.kategori_obat}</td>
                        <td>
                            <input type="text" name="qty" id="qty-${response.data.list_id}" class="form-control" value="${response.data.qty}" style="max-width: 100px;">
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="action-icon" onclick="editobat('${response.data.list_id}')">
                                <i class="mdi mdi-square-edit-outline"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="hapusobat('${response.data.list_id}')" class="action-icon">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </td>
                    </tr>
                `;
                        $("#obatList").append(newRow);
                        $("#obat-modal").modal("hide");
                        console.log(response.data);
                    } else {
                        alert('Terjadi kesalahan saat menyimpan data.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan data.');
                }
            });
            return false;
        });

        function editobat(list_id) {
            var url = "{{ route('detail.updateobatpasien') }}";
            var currentQty = $('#qty-' + list_id).val();
            var newData = {
                'list_id': list_id,
                'qty': currentQty,
                '_token': $("meta[name='csrf-token']").attr("content")
            }
            $.ajax({
                url: url,
                type: "post",
                dataType: "JSON",
                data: newData,
                success: function(response) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data berhasil diubah',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#qty-' + list_id).val(response.data.qty);
                    console.log(response.data);
                }
            });
        }

        function hapusobat(list_id) {
            var url = "{{ route('listdaftarobat_pasienInap.destroy', ':list_id') }}";
            url = url.replace(':list_id', list_id);
            Swal.fire({
                title: "Yakin ingin menghapus data ini?",
                text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log("berhasil hapus data");
                            $("#row-" + list_id).remove();
                            $("#row-" + $obat.list_id).remove();
                        }
                    })
                }
            })
        }

        // Mencari DataTindakan didalam modal Add Tindakan
        $(document).ready(function() {
            var path = "{{ route('autocomplete_tindakan_pasienInap') }}";
            $("#search-tindakan").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search-tindakan').val(ui.item.label);
                    console.log(ui.item);
                    return false;
                }
            });
        });

        // Menambahkan tindakan melalui modal add tindakan
        $("#submit-tindakan").click(function() {
            var listtindakan = "{{ route('listdaftartindakan_pasienInap.insert') }}";
            var search = $("#search-tindakan").val();
            var kode = $("#kode").val();
            var tgl = $("#tgltindakan").val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: listtindakan,
                type: "POST",
                cache: false,
                data: {
                    "search": search,
                    "kode": kode,
                    "tgltindakan": tgl,
                    "_token": token
                },
                dataType: "json", // Mengatur tipe respons menjadi "json"
                success: function(response) {
                    if (response.success) {
                        // Mengubah format tanggal
                        var formattedDate = new Date(response.data.tanggal);
                        var day = formattedDate.getDate();
                        var month = formattedDate.getMonth() + 1;
                        var year = formattedDate.getFullYear();
                        var formattedDateString =
                            `${day.toString().padStart(2, '0')}/${month.toString().padStart(2, '0')}/${year}`;

                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            var newRow = `
                    <tr id="row-${response.data.list_id}">
                        <td>${formattedDateString}</td>
                        <td>${response.data.nama_tindakan}</td>
                        <td>
                            <a href="#" class="tindakan" data-bs-toggle="modal"
                                data-bs-target="#edittindakan-modal"
                                data-id="${response.data.list_id}"
                                data-tgltindakan="${response.data.tanggal}"
                                data-tindakan="${response.data.nama_tindakan}"
                                id="open-edittindakan-modal"><i class="mdi mdi-square-edit-outline"></i></a>
                            <a href="javascript:void(0)" onclick="hapustindakan('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                `;
                            $("#tindakanList").append(newRow);
                            $("#tindakan-modal").modal("hide");
                        });
                    } else {
                        // Tampilkan pesan error jika diperlukan
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan data',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function() {
                    // Tampilkan pesan error jika terjadi kesalahan AJAX
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan saat menyimpan data',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
            return false;
        });

        $(document).on('click', '.tindakan', function() {
            var listId = $(this).data('id');
            var tgltindakan = $(this).data('tgltindakan');
            var tindakan = $(this).data('tindakan');

            $('#edit-tindakan-id').val(listId);
            $('#edittgltindakan').val(tgltindakan);
            $('#search-edittindakan').val(tindakan);

            $('#edittindakan-modal').modal('show');
        });

        // Mencari DataTindakan didalam modal Edit Tindakan
        $(document).ready(function() {
            var path = "{{ route('autocomplete_tindakan_pasienInap') }}";
            $("#search-edittindakan").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search-edittindakan').val(ui.item.label);
                    console.log(ui.item);
                    return false;
                }
            });
        });

        $(document).ready(function() {
            $("#submit-edittindakan").click(function(e) {
                e.preventDefault();

                var url = "{{ route('listdaftartindakan_pasienInap.update') }}";
                var search = $("#search-edittindakan").val();
                var kode = $("#kodedaftar").val();
                var tgl = $("#edittgltindakan").val();
                var list_id = $("#edit-tindakan-id").val();
                let token = $("meta[name='csrf-token']").attr("content");

                var newData = {
                    "search": search,
                    "kode": kode,
                    "tgltindakan": tgl,
                    "list_id": list_id,
                    "_token": token
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    data: newData,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Mengubah format tanggal
                            var formattedDate = new Date(response.data.tanggal);
                            var day = formattedDate.getDate();
                            var month = formattedDate.getMonth() + 1;
                            var year = formattedDate.getFullYear();
                            var formattedDateString =
                                `${day.toString().padStart(2, '0')}/${month.toString().padStart(2, '0')}/${year}`;

                            // Memperbarui data pada tabel
                            var $tableRow = $(`#row-${response.data.list_id}`);
                            if ($tableRow.length) {
                                $tableRow.find('td:first-child').text(formattedDateString);
                                $tableRow.find('td:nth-child(2)').text(response.data
                                    .nama_tindakan);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil disimpan',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $("#edittindakan-modal").modal("hide");
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan saat menyimpan data',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan data',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
                return false;
            });
        });

        function hapustindakan(list_id) {
            var url = "{{ route('listdaftartindakan_pasienInap.destroy', ':list_id') }}";
            url = url.replace(':list_id', list_id);
            Swal.fire({
                title: "Yakin ingin menghapus data ini?",
                text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log("berhasil hapus data");
                            $("#row-" + list_id).remove();
                            $("#row-" + tindakan.list_id).remove();
                        }
                    })
                }
            })
        }

        $(document).ready(function() {
            $('#pemeriksaan-selesai').click(function() {
                var pemeriksaan = 'Tertangani';
                var kode = $("#kode").val();
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    type: 'POST',
                    url: "{{ route('detail.pemeriksaanpasieninap') }}",
                    data: {
                        action: 'update',
                        pemeriksaan: 'Tertangani',
                        kode: kode,
                        _token: token,
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                        }).then(function() {
                            window.location.href =
                                '{{ route('list-daftar-pasienInap') }}';
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

        $(document).ready(function() {
            var path = "{{ route('autocomplete_rujukan_pasieninap') }}";
            $("#search-rujukan").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search-rujukan').val(ui.item.label);
                    $("#search-rujukan").data("selected-id", ui.item.value);
                    console.log(ui.item);
                    return false;
                }
            });
        });

        $("#add-rujukan").click(function() {
            var listrujukan = "{{ route('listdaftarrujukanpasieninap.insert') }}";
            var search = $("#search-rujukan").data("selected-id");
            var kode = $("#kode").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: listrujukan,
                type: "POST",
                cache: false,
                data: {
                    "search": search,
                    "kode": kode,
                    "_token": token
                },
                success: function(response) {
                    var newRow = `
                        <tr id="row-${response.data.list_id}">
                            <td>${response.data.nama_lab}</td>
                            <td>${response.data.keterangan || 'Belum ada keterangan'}</td>
        <td>
            ${response.data.file ? `<a href="${response.data.file}" download><i class="uil-download-alt h3"></i></a>` : 'Belum ada file'}
        </td>
                            <td>${response.data.status}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="hapusrujukan('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    `;
                    $("#rujukanList").append(newRow);
                    console.log(response.data);
                }
            });
        });

        function hapusrujukan(list_id) {
            var url = "{{ route('listdaftarrujukanpasieninap.destroy', ':list_id') }}";
            url = url.replace(':list_id', list_id);
            Swal.fire({
                title: "Yakin ingin menghapus data ini?",
                text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log("berhasil hapus data");
                            $("#row-" + list_id).remove();
                            $("#row-" + $rujukan.list_id).remove();
                        }
                    })
                }
            })
        }
    </script>
@endsection
