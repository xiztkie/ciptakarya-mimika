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

    <h3 class="report-title">Laporan Rincian Paket Pekerjaan Per Penyedia</h3>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Perusahaan</th>
                <th rowspan="2">Jenis Penyedia</th>
                <th colspan="4">Jenis Pengadaan</th>
                <th rowspan="2">Total Paket</th>
            </tr>
            <tr>
                <th>Pengadaan Barang</th>
                <th>Pekerjaan Konstruksi</th>
                <th>Jasa Konsultansi</th>
                <th>Jasa Lainnya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendor as $item)
                @php
                    $pengadaanBarang = $paket
                        ->where('npwp_penyedia', $item->npwp_penyedia)
                        ->where('jenis_pengadaan', 'Pengadaan Barang')
                        ->count();
                    $pekerjaanKonstruksi = $paket
                        ->where('npwp_penyedia', $item->npwp_penyedia)
                        ->where('jenis_pengadaan', 'Pekerjaan Konstruksi')
                        ->count();
                    $jasaKonsultansi = $paket
                        ->where('npwp_penyedia', $item->npwp_penyedia)
                        ->where('jenis_pengadaan', 'Jasa Konsultansi')
                        ->count();
                    $jasaLainnya = $paket
                        ->where('npwp_penyedia', $item->npwp_penyedia)
                        ->where('jenis_pengadaan', 'Jasa Lainnya')
                        ->count();
                    $totalPaket = $pengadaanBarang + $pekerjaanKonstruksi + $jasaKonsultansi + $jasaLainnya;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $item->nama_penyedia }}</td>
                    <td class="text-center">
                        @if ($item->oap == 1)
                            OAP
                        @else
                            Non OAP
                        @endif
                    </td>
                    <td class="text-center">{{ $pengadaanBarang }}</td>
                    <td class="text-center">{{ $pekerjaanKonstruksi }}</td>
                    <td class="text-center">{{ $jasaKonsultansi }}</td>
                    <td class="text-center">{{ $jasaLainnya }}</td>
                    <td class="text-center font-bold">{{ $totalPaket }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
