<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 16pt; font-weight: bold;">PEMERINTAH KABUPATEN MIMIKA
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 18pt; font-weight: bold;">
                {{ strtoupper('Dinas Pekerjaan Umum dan Tata Ruang') }}</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; font-size: 10pt;">Alamat: Jl. Cenderawasih No. 1, Timika, Papua
            </th>
        </tr>
        <tr>
            <th colspan="6"
                style="text-align: center; font-size: 14px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                Laporan Rincian Paket Pekerjaan Per Penyedia</th>
        </tr>
        <tr></tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold;">No</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 400px;">Nama
                Perusahaan</th>
            <th colspan="4"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold;">Jenis
                Pengadaan</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 150px;">Total
                Paket</th>
        </tr>
        <tr>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 150px;">
                Pengadaan Barang</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 150px;">
                Pekerjaan Konstruksi</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 150px;">Jasa
                Konsultansi</th>
            <th style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 150px;">Jasa
                Lainnya</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vendor as $item)
           @php
                    $pengadaanBarang = $paket->where('npwp_penyedia', $item->npwp_penyedia)->where('jenis_pengadaan', 'Pengadaan Barang')->count();
                    $pekerjaanKonstruksi = $paket->where('npwp_penyedia', $item->npwp_penyedia)->where('jenis_pengadaan', 'Pekerjaan Konstruksi')->count();
                    $jasaKonsultansi = $paket->where('npwp_penyedia', $item->npwp_penyedia)->where('jenis_pengadaan', 'Jasa Konsultansi')->count();
                    $jasaLainnya = $paket->where('npwp_penyedia', $item->npwp_penyedia)->where('jenis_pengadaan', 'Jasa Lainnya')->count();
                    $totalPaket = $pengadaanBarang + $pekerjaanKonstruksi + $jasaKonsultansi + $jasaLainnya;
                @endphp
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $item->nama_penyedia }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $pengadaanBarang }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $pekerjaanKonstruksi }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $jasaKonsultansi }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $jasaLainnya }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $totalPaket }}</td>
                </tr>

        @endforeach
    </tbody>
</table>
