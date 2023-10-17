@extends('main')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Detail Transaksi Pembayaran</a></li>
                        </ol>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0);" onclick="history.back();">
                            <i class="uil-left-arrow-from-left h1"></i>
                        </a>
                        <h4 class="page-title">Detail Transaksi Pembayaran Pasien Rawat Jalan</h4>
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
                    <div class="tab-content mb-1">
                        {{-- tab-pane diagnosa --}}
                        <div id="notification"></div>
                        <div class="tab-pane show active" id="keluhan">
                            <!-- comment box -->
                            <div class="row mb-3">
                                <div class="keluhan-list">
                                    @foreach ($dtpendaftar as $list)
                                        <div class="keluhan-item">
                                            <label>Keluhan:</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $list->keluhan }}</textarea>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- end tab-pane obat --}}
                    </div>
                    <div class="tab-content mb-1">
                        {{-- tab-pane diagnosa --}}
                        <div id="notification"></div>
                        <div class="tab-pane show active" id="diagnosa">
                            <!-- comment box -->
                            <div class="row mb-3">
                                <div class="diagnosa-list">
                                    @foreach ($dtpendaftar as $list)
                                        <div class="diagnosa-item">
                                            <label>Diagnosa:</label>
                                            <textarea class="form-control" rows="3" readonly>{{ $list->diagnosa }}</textarea>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- end tab-pane obat --}}
                    </div>
                    <!-- end .border-->
                    <!-- end comment box -->
                    <div class="tab-content mb-1">
                        {{-- tab-pane obat --}}
                        <div class="tab-pane show active" id="obat">
                            <!-- comment box -->
                            <div class="row mb-1">
                                @foreach ($dtlistobat as $list)
                                    <form action="{{ route('transaksi-obat.detail.update', $list->kode_pendaftaran) }}"
                                        method="post">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-centered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Kategori Obat</th>
                                                        <th>Qty</th>
                                                        <th>Status</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="obatList">
                                                    @foreach ($dtlistobat as $obat)
                                                        <tr id="row-{{ $obat->list_id }}">
                                                            <td>{{ $obat->nama_obat }}</td>
                                                            <td>{{ $obat->kategori_obat }}</td>
                                                            <td>{{ $obat->qty }}</td>
                                                            <td>{{ $obat->status }}</td>
                                                            <td>{{ number_format($obat->obat->harga_jual, 0, ',', '.') }}
                                                            </td>
                                                            <td>{{ number_format($total, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                        {{-- end tab-pane obat --}}
                    </div>
                    {{-- tindakan --}}
                    <div class="tab-content mb-1">
                        {{-- tab-pane tindakan --}}
                        <div class="tab-pane show active" id="tindakan">
                            <!-- comment box -->
                            <div class="row mb-1">
                                <div class="table-responsive">
                                    <table class="table table-centered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tindakan</th>
                                                <th>Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody id="obatList">
                                            @foreach ($dtlisttindakan as $tindakan)
                                                <tr id="row-{{ $obat->list_id }}">
                                                    <td>{{ $tindakan->tindakan->nama_tindakan }}</td>
                                                    <td>{{ number_format($tindakan->tindakan->harga_tindakan, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end tab-pane obat --}}
                    </div>
                    {{-- rujukan --}}
                    <div class="tab-content mb-1">
                        {{-- tab-pane tindakan --}}
                        <div class="tab-pane show active" id="rujukan">
                            <!-- comment box -->
                            <div class="row mb-1">
                                <div class="table-responsive">
                                    <table class="table table-centered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Rujukan</th>
                                                <th>Tindakan</th>
                                                <th>Biaya</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rujukanList">
                                            @foreach ($dtlistrujukan as $rujukan)
                                                <tr id="row-{{ $rujukan->list_id }}">
                                                    <td>{{ $rujukan->lab->nama_lab }}</td>
                                                    <td>{{ $rujukan->tindakanlab->nama_tindakan }}</td>
                                                    <td>{{ number_format($rujukan->tindakanlab->harga_tindakan, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end tab-pane obat --}}
                    </div>

                    <div class="tab-content mb-1">
                        <div class="row mb-3 mt-2 m-3">
                            <div class="col-md-2">
                                <label for="grandtotal" class="form-label-md-6">Grandtotal</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="grandtotal" id="grandtotal" class="form-control"
                                    value="{{ number_format($grandtotal, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3 mt-2 m-3">
                            <div class="col-md-2">
                                <label for="dibayar" class="form-label-md-6">Dibayar</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="dibayar" id="dibayar" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3 mt-2 m-3">
                            <div class="col-md-2">
                                <label for="kembalian" class="form-label-md-6">Kembalian</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="kembalian" id="kembalian" class="form-control">
                            </div>
                        </div>
                        @foreach ($dtpendaftar as $pendaftar)
                            <div class="d-flex justify-content-center mt-5">
                                <button type="submit" id="simpan-{{ $pendaftar->kode_pendaftaran }}"
                                    class="btn btn-sm btn-dark waves-effect">Simpan</button>
                            </div>
                        @endforeach

                    </div>
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
        const grandtotalInput = document.getElementById('grandtotal');
        const dibayarInput = document.getElementById('dibayar');
        const kembalianInput = document.getElementById('kembalian');
        const editButton = document.getElementById('simpan');

        dibayarInput.addEventListener('input', function() {
            const grandtotal = parseFloat(grandtotalInput.value.replace(/\./g, '').replace(',', '.'));
            const dibayar = parseFloat(dibayarInput.value.replace(/\./g, '').replace(',', '.'));

            if (!isNaN(grandtotal) && !isNaN(dibayar)) {
                const kembalian = dibayar - grandtotal;
                kembalianInput.value = kembalian.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            } else {
                kembalianInput.value = '';
            }
        });


        const simpanButtons = document.querySelectorAll('[id^="simpan-"]');
        simpanButtons.forEach(button => {
            button.addEventListener('click', function() {
                const pendaftaranId = button.id.split('-')[
                    1];

                const dibayarInput = document.getElementById(`dibayar`);
                const grandtotalInput = document.getElementById(`grandtotal`);

                const dibayar = parseFloat(dibayarInput.value.replace(/\./g, '').replace(',', '.'));
                const grandtotal = parseFloat(grandtotalInput.value.replace(/\./g, '').replace(',', '.'));

                if (!isNaN(dibayar) && !isNaN(grandtotal)) {
                    const formData = new FormData();
                    formData.append('grandtotal', grandtotal);
                    formData.append('dibayar', dibayar);

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');
                    formData.append('_token', csrfToken);

                    fetch(`/admin/transaksi-pembayaran-rawatjalan/detail/update/${pendaftaranId}`, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert('Berhasil menyimpan data!');
                            window.location.href = '{{ route('transaksi-pembayaran-rawatjalan') }}';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        });
    </script>
@endsection
