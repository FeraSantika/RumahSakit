<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Pendaftaran Pasien Rawat Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px;
        }

        .card-title {
            font-size: 20px;
        }

        h4 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex align-items-center mb-3">
            <div class="d-flex align-items-center">
                <div class="text-center">
                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($rs->logo_rumahsakit)) }}"
                        alt="image" width="35px"
                        style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                    <h1 style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                        {{ $rs->nama_rumahsakit }}</h1>
                    <h5 style="margin-bottom: 5px; margin-top: 2px">{{ $rs->alamat_rumahsakit }} || {{ $rs->telp_rumahsakit }} ||
                        {{ $rs->email_rumahsakit }}</h5>
                    <hr class="my-1" style="height: 2px; background-color: black; width: 100%; margin: 5px 0;">
                    <hr class="my-1">
                </div>
            </div>
            <p>Rentang Tanggal:
                @if ($tglAwal && $tglAkhir)
                    {{ $tglAwal }} hingga {{ $tglAkhir }}
                @else
                    Data tanggal tidak diinputkan
                @endif
            </p>
            <p>Status Pasien :
                @if (!empty($statusPasien))
                    {{ $statusPasien }}
                @else
                    Semua status
                @endif
            </p>
            <p>Status Pemeriksaan :
                @if (!empty($statusPemeriksaan))
                    {{ $statusPemeriksaan }}
                @else
                    Semua pemeriksaan
                @endif
            </p>
            <p>Poli :
                @if (!empty($namaPoli))
                    {{ $namaPoli }}
                @else
                    Semua poli
                @endif
            </p>
        </div>
        <h4>Laporan Pendaftaran Pasien Rawat Jalan</h4>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Kode Pendaftaran</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Status Pasien</th>
                        <th scope="col">Poli</th>
                        <th scope="col">Keluhan</th>
                        <th scope="col">Status Pemeriksaan</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($dtpendaftar->isEmpty())
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                    @foreach ($dtpendaftar as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                            <td>
                                @if ($item->user)
                                    {{ $item->user->User_name }}
                                @else
                                    Dokter Tidak Tersedia
                                @endif
                            </td>
                            <td>{{ $item->kode_pendaftaran }}</td>
                            <td>
                                @if (isset($item->pasien))
                                    {{ $item->pasien->pasien_nama }}
                                @endif
                            </td>
                            <td>
                                @if ($item->status_pasien === 'Umum')
                                    <span class="badge bg-success">{{ $item->status_pasien }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $item->status_pasien }}</span>
                                @endif
                            </td>
                            <td>{{ $item->poli->nama_poli }}</td>
                            <td>{{ $item->keluhan }}</td>
                            <td>
                                @if ($item->status_pemeriksaan === 'Tertangani')
                                    <span class="badge bg-success">{{ $item->status_pemeriksaan }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $item->status_pemeriksaan }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
