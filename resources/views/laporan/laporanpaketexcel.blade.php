<table>
    <thead>
        <tr>
            <th colspan="20" style="text-align: center; font-size: 16pt; font-weight: bold;">PEMERINTAH KABUPATEN MIMIKA
            </th>
        </tr>
        <tr>
            <th colspan="20" style="text-align: center; font-size: 18pt; font-weight: bold;">
                {{ strtoupper('Dinas Pekerjaan Umum dan Tata Ruang') }}</th>
        </tr>
        <tr>
            <th colspan="20" style="text-align: center; font-size: 10pt;">Alamat: Jl. Cenderawasih SP.III Kantor Pusat
                Pemerintahan Gedung D Lt.1, Timika 99911
            </th>
        </tr>
        <tr>
            <th colspan="20"
                style="text-align: center; font-size: 14px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                Laporan Rincian Paket Pekerjaan</th>
        </tr>
        <tr></tr>
    </thead>
</table>
<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 30px;">
                No</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 400px;">
                Nama Pekerjaan</th>
            <th colspan="5"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; ">
                Nilai (Rp)</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 300px;">
                PPK</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 200px;">
                Sumber Dana</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 200px;">
                Sub Sumber Dana</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Jenis Pengadaan</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Metode Pengadaan</th>
            <th colspan="4"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; ">
                Penyedia</th>
            <th colspan="4"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; ">
                Bangunan</th>
            <th rowspan="2"
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Keterangan</th>
        </tr>
        <tr>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold;  width: 250px;">
                Pagu</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold;  width: 250px;">
                HPS</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold;  width: 250px;">
                Penawaran</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold;  width: 250px;">
                Kontrak</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold;  width: 250px;">
                Efisiensi</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Nama</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Pimpinan</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                NPWP</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                OAP/NON-OAP</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Kategori</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Jenis</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Umur</th>
            <th
                style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; width: 250px;">
                Lokasi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($paket as $p)
            <tr>
                <td style="border: 1px solid black; text-align: center; white-space: normal;">{{ $loop->iteration }}
                </td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->nama_paket }}</td>
                <td style="border: 1px solid black; text-align: right; white-space: normal;">{{ $p->pagu ?? 0 }}</td>
                <td style="border: 1px solid black; text-align: right; white-space: normal;">{{ $p->hps ?? 0 }}</td>
                <td style="border: 1px solid black; text-align: right; white-space: normal;">
                    {{ $p->nilai_penawaran ?? 0 }}</td>
                <td style="border: 1px solid black; text-align: right; white-space: normal;">
                    {{ $p->nilai_kontrak ?? 0 }}</td>
                <td style="border: 1px solid black; text-align: right; white-space: normal;">
                    @php
                        $efisiensi = ($p->pagu ?? 0) - ($p->nilai_kontrak ?? 0);
                        echo $efisiensi;
                    @endphp
                </td>
                <td style="border: 1px solid black; white-space: normal;">
                    {{ $p->nama_ppk ? ucwords(strtolower($p->nama_ppk)) : '-' }} -
                    {{ $p->nip_ppk }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->sumber_dana ?? '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->sub_sumberdana ?? '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->jenis_pengadaan ?? '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->metode_pengadaan ?? '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->nama_penyedia ?? '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">
                    {{ $p->wakil_sah_penyedia ? ucwords(strtolower($p->wakil_sah_penyedia)) : '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->npwp_penyedia ?? '-' }}</td>
                <td style="border: 1px solid black; text-align: center; white-space: normal;">
                    {{ $p->oap ? 'OAP' : 'NON OAP' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->kategori ?? '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->jenis ?? '-' }}</td>
                <td style="border: 1px solid black; text-align: center; white-space: normal;">
                    @if ($p->umur)
                        @php
                            $diff = \Carbon\Carbon::parse($p->umur)->diff(\Carbon\Carbon::now());
                        @endphp
                        {{ $diff->y > 0 ? $diff->y . ' tahun ' : '' }}{{ $diff->m > 0 ? $diff->m . ' bulan ' : '' }}{{ $diff->d > 0 ? $diff->d . ' hari' : '' }}
                    @else
                        -
                    @endif
                </td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->detail_lokasi ?? '-' }}</td>
                <td style="border: 1px solid black; white-space: normal;">{{ $p->keterangan ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="20" style="border: 1px solid black; text-align: center; white-space: normal;">
                    Tidak ada data paket yang tersedia.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<table style="width:100%; border:none; margin-top:40px;">
    <tr>
        <td style=" text-align:center; border:none;" colspan="10">

        </td>
        <td style="text-align:center; border:none;" colspan="10">
            Mengetahui,
        </td>
    </tr>
    <tr>
        <td style="text-align:center; border:none;" colspan="10">
            Kepala Bidang
        </td>
        <td style="text-align:center; border:none;" colspan="10">
            Kepala Dinas
        </td>
    </tr>
    <tr>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
    </tr>
    <tr>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
    </tr>
    <tr>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
    </tr>
    <tr>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
        <td style="text-align:center; border:none;" colspan="10">
        </td>
    </tr>
    <tr>
        <td style="text-align:center; border:none;" colspan="10">
            <b><u>{{ $kabid ?? 'Nama Kepala Bidang' }}</u></b>
        </td>
        <td style="text-align:center; border:none;" colspan="10">
            <b><u>{{ $kadis ?? 'Nama Kepala Dinas' }}</u></b>
        </td>
    </tr>
    <tr>
        <td style="text-align:center; border:none;" colspan="10">
            NIP. {{ $nip_kabid ?? '-' }}
        </td>
        <td style="text-align:center; border:none;" colspan="10">
            NIP. {{ $nip_kadis ?? '-' }}
        </td>
    </tr>
</table>
