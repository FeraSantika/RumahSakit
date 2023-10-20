@extends('layouts.app')
@section('content')
    <style>
        /* .col {
                        border: 2px solid #000000;
                    }

                    .row {
                        border: 2px solid #000000;
                    } */
    </style>
    <div class="container-fluid">
        <div class="card mt-5 mb-5">
            <div class="card-body">
                <div class="row mt-5">
                    <div class="col-1">
                        <div class="d-flex justify-content-between mb-2 mr-5">
                            <img src="{{ asset('assets/images/profile.png') }}" class="rounded-circle" width="80"
                                height="90">
                        </div>
                    </div>
                    @foreach ($pasien as $item)
                        <div class="col">
                            <div class="row">
                                <h4>Nama lengkap</h4>
                                <p>{{ $item->pasien_nama }}</p>
                            </div>
                            <div class="row">
                                <h4>Tanggal Lahir</h4>
                                <p>{{ $item->pasien_tgl_lahir }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <h4>NIK</h4>
                                <p>{{ $item->pasien_NIK }}</p>
                            </div>
                            <div class="row">
                                <h4>Jenis Kelamin</h4>
                                <p>{{ $item->pasien_jenis_kelamin }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <h4>Alamat</h4>
                                <p>{{ $item->pasien_alamat }}</p>
                            </div>
                            <div class="row">
                                <h4>Kewarganegaraan</h4>
                                <p>{{ $item->pasien_kewarganegaraan }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <h4>Pekerjaan</h4>
                                <p>{{ $item->pasien_pekerjaan }}</p>
                            </div>
                            <div class="row">
                                <h4>Agama</h4>
                                <p>{{ $item->pasien_agama }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 mx-auto ml-auto">
            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Riwayat pemeriksaan rawat jalan</h4>
                        <div class="dropdown">
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
                                                <label><b>Poli:</b></label>
                                                <p>{{ $item->poli->nama_poli }}</p>
                                                <hr>
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
                                                <h5>List Daftar Rujukan</h5>
                                                <div class="row mb-2">
                                                    <div class="table-responsive">
                                                        <table class="table table-centered dt-responsive">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 50px">Rujukan</th>
                                                                    <th style="width: 50px">Keterangan</th>
                                                                    <th style="width: 50px">File</th>
                                                                    <th style="width: 50px">Status Rujukan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="rujukanList">
                                                                <tr id="row">
                                                                    <td>{{ $item->listrujukan->lab->nama_lab ?? '' }}
                                                                    </td>
                                                                    <td>{{ $item->listrujukan->keterangan ?? '' }}
                                                                    </td>
                                                                    <td><a href="{{ asset('uploads/' . ($rujukan->filerujukan ?? '')) }}"
                                                                            download><i class="uil-download-alt h3"></i></a>
                                                                    </td>
                                                                    <td>{{ $item->listrujukan->status ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>{{-- end Tabel Rujukan --}}
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
            </div>
        </div>
        <div class="col-md-6 mx-auto ml-auto">
            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Riwayat pemeriksaan rawat inap</h4>
                        <div class="dropdown">
                        </div>
                    </div>

                    <div class="inbox-widget">
                        <div class="inbox-item">
                            @foreach ($dtriwayatinap as $item)
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
                                                <h5>List Daftar Rujukan</h5>
                                                <div class="row mb-2">
                                                    <div class="table-responsive">
                                                        <table class="table table-centered dt-responsive">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 50px">Rujukan</th>
                                                                    <th style="width: 50px">Keterangan</th>
                                                                    <th style="width: 50px">File</th>
                                                                    <th style="width: 50px">Status Rujukan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="rujukanList">
                                                                <tr id="row">
                                                                    <td>{{ $item->listrujukan->lab->nama_lab ?? '' }}
                                                                    </td>
                                                                    <td>{{ $item->listrujukan->keterangan ?? '' }}
                                                                    </td>
                                                                    <td><a href="{{ asset('uploads/' . ($rujukan->filerujukan ?? '')) }}"
                                                                            download><i
                                                                                class="uil-download-alt h3"></i></a>
                                                                    </td>
                                                                    <td>{{ $item->listrujukan->status ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>{{-- end Tabel Rujukan --}}
                                                <h5>List Daftar Kamar Inap</h5>
                                                <div class="row mb-2">{{-- tabel kamarinap --}}
                                                    <div class="table-responsive">
                                                        <table class="table table-centered">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Nama Kamar</th>
                                                                    <th>Nomor Kamar</th>
                                                                    <th>Tanggal Masuk</th>
                                                                    <th>Tanggal Keluar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="kamarList">
                                                                <?php $totalharga = 0; ?>
                                                                @foreach ($dtlistkamar as $kamar)
                                                                    <tr id="row-{{ $kamar->id_kamar_pasieninap }}">
                                                                        <td>{{ $kamar->kamar->nama_kamar_inap }}</td>
                                                                        <td class="text-center">
                                                                            {{ $kamar->kamar->nomor_kamar_inap }}</td>
                                                                        <td>{{ $kamar->tanggal_masuk }}</td>
                                                                        <td>{{ $kamar->tanggal_keluar }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>{{-- end tabel kamarinap --}}
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
            </div>
        </div>
    </div>
@endsection
