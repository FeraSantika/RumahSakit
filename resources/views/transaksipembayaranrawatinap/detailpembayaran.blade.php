@extends('main')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Detail Transaksi Pembayaran Rawat
                                    Inap</a></li>
                        </ol>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" onclick="history.back();">
                                <i class="uil-left-arrow-from-left h1"></i>
                            </a>
                            <h4 class="page-title">Detail Transaksi Pembayaran Pasien Rawat Inap</h4>
                        </div>
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
                    <div class="tab-content mb-1">{{-- tab-pane keluhan --}}
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
                    </div>{{-- end tab-pane keluhan --}}

                    <div class="tab-content mb-1">{{-- tabel diagnosa --}}
                        <div class="row mb-1">
                            <div class="table-responsive">
                                <table class="table table-centered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal Diagnosa</th>
                                            <th>Diagnosa</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kamarList">
                                        <?php $totalharga = 0; ?>
                                        @foreach ($dtdiagnosa as $diagnosa)
                                            <tr id="row-{{ $diagnosa->id_diagnosa_pasieninap }}">
                                                <td>{{ $diagnosa->tanggal }}</td>
                                                <td>{{ $diagnosa->diagnosa }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>{{-- end tabel diagnosa --}}

                    <div class="tab-content mb-1">{{-- tabel kamarinap --}}
                        <div class="row mb-1">
                            <div class="table-responsive">
                                <table class="table table-centered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Kamar</th>
                                            <th>Nomor Kamar</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Lama</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kamarList">
                                        <?php $totalharga = 0; ?>
                                        @foreach ($dtlistkamar as $kamar)
                                            <tr id="row-{{ $kamar->id_kamar_pasieninap }}">
                                                <td>{{ $kamar->kamar->nama_kamar_inap }}</td>
                                                <td class="text-center">{{ $kamar->kamar->nomor_kamar_inap }}</td>
                                                <td>{{ $kamar->tanggal_masuk }}</td>
                                                <td>{{ $kamar->tanggal_keluar }}</td>

                                                <?php
                                                $tanggalMasuk = new DateTime($kamar->tanggal_masuk);
                                                $tanggalKeluar = new DateTime($kamar->tanggal_keluar);
                                                $selisih = $tanggalMasuk->diff($tanggalKeluar)->days;

                                                $kamarinap = $kamar->kamar->harga_kamar_inap;
                                                $harga = $kamarinap * $selisih;
                                                $totalharga += $harga;
                                                ?>

                                                <td>{{ $selisih }} Hari</td>
                                                <td>{{ number_format($kamarinap, 0, ',', '.') }}</td>
                                                <td>{{ number_format($harga, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="text-end"><strong>Grand Total:</strong></td>
                                            <td><b>{{ number_format($totalharga, 0, ',', '.') }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>{{-- end tabel kamarinap --}}

                    <div class="tab-content mb-1">{{-- tabel obat --}}
                        <div class="row mb-1">
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
                                        <?php
                                        $totalhargaobat = 0;
                                        ?>
                                        @foreach ($dtlistobat as $obat)
                                            <tr id="row-{{ $obat->list_id }}">
                                                <td>{{ $obat->nama_obat }}</td>
                                                <td>{{ $obat->kategori_obat }}</td>
                                                <td>{{ $obat->qty }}</td>
                                                <td>{{ $obat->status }}</td>
                                                <td>{{ number_format($obat->obat->harga_jual, 0, ',', '.') }}
                                                </td>
                                                <?php
                                                $harga = $obat->qty * $obat->obat->harga_jual;
                                                $totalhargaobat += $harga;
                                                ?>
                                                <td class="text-end">{{ number_format($harga, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                            <td class="text-end"><b>{{ number_format($totalhargaobat, 0, ',', '.') }}</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>{{-- end tabel obat --}}

                    <div class="tab-content mb-1">{{-- tab-pane tindakan --}}
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
                                        <?php
                                        $totalhargatindakan = 0;
                                        ?>
                                        @foreach ($dtlisttindakan as $tindakan)
                                            <tr id="row-{{ $obat->list_id }}">
                                                <td>{{ $tindakan->tindakan->nama_tindakan }}</td>
                                                <td class="text-end">
                                                    {{ number_format($tindakan->tindakan->harga_tindakan, 0, ',', '.') }}
                                                </td>
                                                <?php
                                                $totalhargatindakan += $tindakan->tindakan->harga_tindakan;
                                                ?>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td><strong>Grand Total:</strong></td>
                                            <td class="text-end">
                                                <b>{{ number_format($totalhargatindakan, 0, ',', '.') }}</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>{{-- end tab-pane tindakan --}}

                    <div class="tab-content mb-1">{{-- tabel rujukan --}}
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
                                    <tbody id="obatList">
                                        <?php
                                        $totalhargarujukan = 0;
                                        ?>
                                        @foreach ($dtlistrujukan as $rujukan)
                                            <tr id="row-{{ $rujukan->list_id }}">
                                                <td>{{ $rujukan->lab->nama_lab }}</td>
                                                <td>{{ $rujukan->tindakanlab->nama_tindakan }}</td>
                                                <?php
                                                $totalhargarujukan += $rujukan->tindakanlab->harga_tindakan;
                                                ?>
                                                <td class="text-end">
                                                    {{ number_format($rujukan->tindakanlab->harga_tindakan, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="2" class="text-end"><strong>Grand Total:</strong></td>
                                            <td class="text-end">
                                                <b>{{ number_format($totalhargarujukan, 0, ',', '.') }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>{{-- end tabel rujukan --}}


                    <?php
                    $grandtotal = 0;

                    $totalhargaKamar = 0;
                    foreach ($dtlistkamar as $kamar) {
                        $tanggalMasuk = new DateTime($kamar->tanggal_masuk);
                        $tanggalKeluar = new DateTime($kamar->tanggal_keluar);
                        $selisih = $tanggalMasuk->diff($tanggalKeluar)->days;

                        $kamarinap = $kamar->kamar->harga_kamar_inap;
                        $harga = $kamarinap * $selisih;
                        $totalhargaKamar += $harga;
                    }

                    $totalhargaObat = 0;
                    foreach ($dtlistobat as $obat) {
                        $harga = $obat->qty * $obat->obat->harga_jual;
                        $totalhargaObat += $harga;
                    }

                    $totalhargaTindakan = 0;
                    foreach ($dtlisttindakan as $tindakan) {
                        $totalhargaTindakan += $tindakan->tindakan->harga_tindakan;
                    }

                    $totalhargaRujukan = 0;
                    foreach ($dtlistrujukan as $rujukan) {
                        $totalhargaRujukan += $rujukan->tindakanlab->harga_tindakan;
                    }

                    $grandtotal = $totalhargaKamar + $totalhargaObat + $totalhargaTindakan + $totalhargaRujukan;
                    ?>

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
                const pendaftaranId = button.id.split('-')[1];

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

                    fetch(`/admin/transaksi-pembayaran-rawatinap/detail/update/${pendaftaranId}`, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil menyimpan data!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href =
                                        '{{ route('transaksi-pembayaran-rawatinap') }}';
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        });
    </script>
@endsection
