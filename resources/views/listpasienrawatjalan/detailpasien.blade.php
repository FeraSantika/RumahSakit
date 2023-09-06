@extends('main')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Detail Pasien</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Detail Pasien Rawat Jalan</h4>
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

            <!-- Messages-->
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



        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
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
                    </ul>
                    <div class="tab-content mb-3">
                        {{-- tab-pane diagnosa --}}
                        <div class="tab-pane" id="diagnosa">
                            @foreach ($dtpendaftar as $pendaftar)
                                <form action="{{ route('detail.pasien.diagnosa', $pendaftar->kode_pendaftaran) }}"
                                    class="comment-area-box" method="POST">
                                    @csrf
                                    <div id="notification"></div>
                                    <textarea rows="3" name="diagnosa" class="form-control border-0 resize-none"
                                        placeholder="Write something...."></textarea>
                                    <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                        </div>
                                        <button type="submit" id="submit"
                                            class="btn btn-sm btn-dark waves-effect">Simpan</button>
                                    </div>
                                </form>
                            @endforeach
                            <!-- end obat -->
                        </div> <!-- end tab-pane -->
                        {{-- tab-pane obat --}}
                        <div class="tab-pane show active" id="obat">
                            <!-- comment box -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-end mb-3">
                                        <div class="input-group">
                                            <input type="text" class="typeahead form-control" name="search"
                                                id="search" placeholder="Cari Obat">
                                            <button class="input-group-text btn btn-primary btn-sm" type="button"
                                                id="add"><i class="ri-add-box-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="table-responsive">
                                    <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Kategori Obat</th>
                                                <th>Qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="obatList">
                                            @foreach ($dtlistobat as $obat)
                                                <tr id="row-{{ $obat->list_id }}">
                                                    <td>{{ $obat->nama_obat }}</td>
                                                    <td>{{ $obat->kategori_obat }}</td>
                                                    <td>
                                                        <input type="text" name="qty"
                                                            id="qty-{{ $obat->list_id }}" value="{{ $obat->qty }}"
                                                            class="form-control" style="max-width: 100px;">
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end tab-pane obat --}}
                        {{-- tab-pane tindakan --}}
                        <div class="tab-pane" id="tindakan">
                            <!-- comment box -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-end mb-3">
                                        <div class="input-group">
                                            <input type="text" class="typeahead form-control" name="search"
                                                id="search-tindakan" placeholder="Cari Tindakan">
                                            <button class="input-group-text btn btn-primary btn-sm" type="button"
                                                id="add-tindakan"><i class="ri-add-box-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="table-responsive">
                                    <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tindakan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tindakanList">
                                            @foreach ($dtlisttindakan as $tindakan)
                                                <tr id="row-{{ $tindakan->list_id }}">
                                                    <td>{{ $tindakan->nama_tindakan }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="action-icon"
                                                            onclick="hapus('{{ $tindakan->list_id }}')">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end tab-pane tindakan --}}
                    </div>
                    <!-- end .border-->
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
        $(document).ready(function() {
            var path = "{{ route('autocomplete_obat') }}";
            $("#search").autocomplete({
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
                    $('#search').val(ui.item.label);
                    console.log(ui.item);
                    return false;
                }
            });
        });

        var insertlist = "{{ route('listdaftarobat.insert') }}";
        $("#add").click(function() {
            var search = $("#search").val();
            var kode = $("#kode").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: insertlist,
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
                            <td>${response.data.nama_obat}</td>
                            <td>${response.data.kategori_obat}</td>
                            <td>
                                <input type="text" name="qty" id="qty-${response.data.list_id}" class="form-control" value="${response.data.qty}" style="max-width: 100px;">
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="action-icon" onclick="edit('${response.data.list_id}')">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="hapusobat('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    `;
                    $("#obatList").append(newRow);
                    console.log(response.data);
                }
            });
        });

        function edit(list_id) {
            var url = "{{ route('listdaftarobat.update') }}";
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
            var url = "{{ route('listdaftarobat.destroy', ':list_id') }}";
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

        $(document).ready(function() {
            var path = "{{ route('autocomplete_tindakan') }}";
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


        $("#add-tindakan").click(function() {
            var listtindakan = "{{ route('listdaftartindakan.insert') }}";
            var search = $("#search-tindakan").val();
            var kode = $("#kode").val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: listtindakan,
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
                            <td>${response.data.nama_tindakan}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="hapus('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    `;
                    $("#tindakanList").append(newRow);
                    console.log(response.data);
                }
            });
        });

        function hapus(list_id) {
            var url = "{{ route('listdaftartindakan.destroy', ':list_id') }}";
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
                            $("#row-" + $tindakan.list_id).remove();
                        }
                    })
                }
            })
        }

        $(document).ready(function() {
            $('form.comment-area-box').on('submit', function(event) {
                event.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#notification').html(
                                '<div class="alert alert-success">Pengisian data diagnosa berhasil!</div>'
                            );
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('list-daftar-pasien') }}";
                            }, 250);
                        } else {
                            $('#notification').html('<div class="alert alert-danger">' +
                                response.message + '</div>');
                        }
                    }
                });
            });
        });
    </script>
@endsection
