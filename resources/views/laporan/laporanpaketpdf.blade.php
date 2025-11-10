<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Paket Pekerjaan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .report-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .header-text h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }

        .header-text h2 {
            margin: 5px 0;
            font-size: 18pt;
            font-weight: bold;
        }

        .header-text p {
            margin: 2px 0;
            font-size: 10pt;
        }

        .header-divider {
            border: 0;
            height: 3px;
            background-color: #000;
            margin: 2px auto 0;
        }

        .report-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px 6px;
            vertical-align: middle;
            border: 1px solid #ccc;
            text-align: left;
        }

        thead th {
            background-color: #f2f2f2;
            color: #333;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 7.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .empty-row td {
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="report-header">
        <table class="header-table" style="border: none;">
            <tr>
            <td style="width: 20%; text-align: right; border: none;">
                <img src="{{ public_path('assets/images/logo_mimika.png') }}" class="logo" />
            </td>
            <td class="header-text" style="width: 60%; text-align: center; border: none;">
                <h1>PEMERINTAH KABUPATEN MIMIKA</h1>
                <h2>{{ strtoupper('Dinas Pekerjaan Umum dan Tata Ruang') }}</h2>
                <p>Alamat: Jl. Cenderawasih No. 1, Timika, Papua</p>
            </td>
            <td style="width: 20%; border: none;"></td>
            </tr>
        </table>
        <hr class="header-divider" style="width: 100%; height: 2px; margin-top: 5px;">
        <hr class="header-divider" style="width: 100%; height: 1px;">
    </div>

    <h3 class="report-title">Laporan Rincian Paket Pekerjaan</h3>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Pekerjaan</th>
                <th colspan="5">Nilai (Rp)</th>
                <th rowspan="2">PPK</th>
                <th rowspan="2">Sumber Dana</th>
                <th rowspan="2">Jenis Pengadaan</th>
                <th rowspan="2">Metode Pengadaan</th>
                <th colspan="4">Penyedia</th>
                <th colspan="4">Bangunan</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Pagu</th>
                <th>HPS</th>
                <th>Penawaran</th>
                <th>Kontrak</th>
                <th>Efisiensi</th>
                <th>Nama</th>
                <th>Pimpinan</th>
                <th>NPWP</th>
                <th>OAP/NON-OAP</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Umur</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($paket as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $p->nama_paket }}</td>
                    <td class="text-right">{{ number_format($p->pagu ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($p->hps ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($p->nilai_penawaran ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($p->nilai_kontrak ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">
                        @php
                            $efisiensi = ($p->pagu ?? 0) - ($p->nilai_kontrak ?? 0);
                            echo number_format($efisiensi, 0, ',', '.');
                        @endphp
                    </td>
                    <td>{{ $p->nama_ppk ? ucwords(strtolower($p->nama_ppk)) : '-' }} - {{ $p->nip_ppk }}</td>
                    <td>{{ $p->sumber_dana ?? '-' }}</td>
                    <td>{{ $p->jenis_pengadaan ?? '-' }}</td>
                    <td>{{ $p->metode_pengadaan ?? '-' }}</td>
                    <td>{{ $p->nama_penyedia ?? '-' }}</td>
                    <td>{{ $p->wakil_sah_penyedia ? ucwords(strtolower($p->wakil_sah_penyedia)) : '-' }}</td>
                    <td>{{ $p->npwp_penyedia ?? '-' }}</td>
                    <td class="text-center">{{ $p->oap ? 'OAP' : 'NON OAP' }}</td>
                    <td>{{ $p->kategori ?? '-' }}</td>
                    <td>{{ $p->jenis ?? '-' }}</td>
                    <td class="text-center">
                        @if ($p->umur)
                            @php
                                $diff = \Carbon\Carbon::parse($p->umur)->diff(\Carbon\Carbon::now());
                            @endphp
                            {{ $diff->y > 0 ? $diff->y . ' th ' : '' }}{{ $diff->m > 0 ? $diff->m . ' bln ' : '' }}{{ $diff->d > 0 ? $diff->d . ' hr' : '' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $p->detail_lokasi ?? '-' }}</td>
                    <td>{{ $p->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="20">
                        Tidak ada data paket yang tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
