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
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0);" onclick="history.back();">
                            <i class="uil-left-arrow-from-left h1"></i>
                        </a>
                        <h4 class="page-title">Detail Pasien</h4>
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
            <!-- Messages-->
            <!-- end card-->
        </div> <!-- end col-->
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#obat" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                List Obat
                            </a>
                        </li>
                    </ul>
                    <div id="notification"></div>
                    <div class="tab-content mb-3">
                        {{-- tab-pane obat --}}
                        <div class="tab-pane show active" id="obat">
                            <!-- comment box -->
                            <div class="row mb-5">
                                @foreach ($dtlistobat as $list)
                                    <form action="{{ route('transaksi-obat.detail.update', $list->kode_pendaftaran) }}"
                                        method="post">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-centered w-100 dt-responsive nowrap m-3 mb-5">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Kategori Obat</th>
                                                        <th>Qty</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="obatList">
                                                    @foreach ($dtlistobat as $obat)
                                                        <tr id="row-{{ $obat->list_id }}">
                                                            <td>{{ $obat->nama_obat }}</td>
                                                            <td>{{ $obat->kategori_obat }}</td>
                                                            <td>{{ $obat->qty }}</td>
                                                            <td>
                                                                <select name="status" id="status-{{ $obat->list_id }}"
                                                                    class="form-select" style="width: 150px;">
                                                                    <option value="">{{$obat->status}}</option>
                                                                    <option value="Ada">Ada</option>
                                                                    <option value="Tidak ada">Tidak ada</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="action-icon"
                                                                    onclick="edit('{{ $obat->list_id }}')">
                                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end mt-5">
                                            <button type="submit" id="submit"
                                                class="btn btn-sm btn-dark waves-effect">Simpan</button>
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                        {{-- end tab-pane obat --}}
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
        function edit(list_id) {
            var url = "{{ route('transaksi-obat.list.update') }}";
            var currentStatus = $('#status-' + list_id).val();
            var newData = {
                'list_id': list_id,
                'status': currentStatus,
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
                    $('#status-' + list_id).val(response.data.status);
                    console.log(response.data);
                }
            });
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
                                    "{{ route('transaksi-obat') }}";
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
