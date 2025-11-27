<x-app-layout :title="$title" :subtitle="$subtitle ?? ''">
    <div class="px-4 md:px-6 lg:px-8 max-w-screen-5xl mx-auto mt-20">
        <div
            class="relative overflow-hidden mb-8 bg-gradient-to-br from-blue-50 to-indigo-100 p-6 rounded-2xl shadow-lg border border-gray-200">
            <div
                class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-br from-sky-200 to-cyan-300 rounded-full opacity-40 blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 right-0 translate-x-1/4 translate-y-1/4 w-72 h-72 bg-gradient-to-br from-violet-200 to-purple-300 rounded-full opacity-30 blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10">
                <div
                    class="flex flex-col sm:flex-row justify-between sm:items-center mb-5 pb-4 border-b border-gray-300/70">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center mb-3 sm:mb-0">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 bg-white/60 rounded-lg shadow-sm">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                            </svg>
                        </span>
                        Filter Lanjutan
                    </h3>
                    @if (request()->hasAny(['tahun_anggaran', 'bidang', 'search']))
                        <a href="{{ route('laporanperpenyedia') }}"
                            class="inline-flex items-center justify-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('laporanperpenyedia') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="tahun_anggaran"
                                class="block text-xs font-semibold text-gray-700 mb-1">Tahun</label>
                            <select name="tahun_anggaran" id="tahun_anggaran"
                                class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Semua</option>
                                @foreach ($tahunanggaran as $opt)
                                    <option value="{{ $opt->tahun_anggaran }}"
                                        {{ request('tahun_anggaran') == $opt->tahun_anggaran ? 'selected' : '' }}>
                                        {{ $opt->tahun_anggaran }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="oap" class="block text-xs font-semibold text-gray-700 mb-1">Jenis
                                Penyedia</label>
                            <select name="oap" id="oap"
                                class="w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Semua</option>
                                <option value="1" {{ request('oap') == '1' ? 'selected' : '' }}>OAP</option>
                                <option value="0" {{ request('oap') == '0' ? 'selected' : '' }}>Non OAP</option>
                            </select>
                        </div>
                        <div class="lg:col-span-1">
                            <label for="search"
                                class="block text-xs font-semibold text-gray-700 mb-1">Pencarian</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Cari penyedia...">
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full flex justify-center items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Data Paket Pengadaan Per Penyedia
                    </h3>
                    <div class="flex items-center space-x-4 mt-2 sm:mt-0">

                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                                <svg class="w-4 h-4 mr-1.5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Export</span>
                                <svg class="ml-1.5 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                style="display: none;">
                                <div class="py-1">
                                    <button type="button" data-modal-target="excelmodal"
                                        data-modal-toggle="excelmodal"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        <img src="https://img.icons8.com/color/16/000000/ms-excel.png" class="mr-2"
                                            alt="Excel icon" />
                                        Export Excel
                                    </button>
                                    <button type="button" data-modal-target="pdfmodal" data-modal-toggle="pdfmodal"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        <img src="https://img.icons8.com/color/16/000000/pdf.png" class="mr-2"
                                            alt="PDF icon" />
                                        Export PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-[11px]">
                    <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th rowspan="2" class="px-2 py-2 text-center align-middle border border-gray-200">No
                            </th>
                            <th rowspan="2" class="px-2 py-2 text-center align-middle border border-gray-200">Nama
                                Perusahaan</th>
                            <th rowspan="2" class="px-2 py-2 text-center align-middle border border-gray-200">Jenis
                                Penyedia</th>
                            <th colspan="4" class="px-2 py-2 text-center align-middle border border-gray-200">Jenis
                                Pengadaan
                            </th>
                            <th rowspan="2" class="px-2 py-2 text-center align-middle border border-gray-200">Total
                                Paket</th>
                        </tr>
                        <tr>
                            <th class="px-2 py-2 text-center align-middle border border-gray-200">Pengadaan Barang</th>
                            <th class="px-2 py-2 text-center align-middle border border-gray-200">Pekerjaan Konstruksi
                            </th>
                            <th class="px-2 py-2 text-center align-middle border border-gray-200">Jasa Konsultansi</th>
                            <th class="px-2 py-2 text-center align-middle border border-gray-200">Jasa Lainnya</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-xs">
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
                                <td class="px-2 py-2 text-center align-middle border border-gray-200">
                                    {{ $loop->iteration }}</td>
                                <td class="px-2 py-2 text-center align-middle border border-gray-200">
                                    {{ $item->nama_penyedia }}</td>
                                <td class="px-2 py-2 text-center align-middle border border-gray-200">
                                    @if ($item->oap == 1)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-800">
                                            OAP
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-800">
                                            Non OAP
                                        </span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 text-center align-middle border border-gray-200">
                                    {{ $pengadaanBarang }}</td>
                                <td class="px-2 py-2 text-center align-middle border border-gray-200">
                                    {{ $pekerjaanKonstruksi }}</td>
                                <td class="px-2 py-2 text-center align-middle border border-gray-200">
                                    {{ $jasaKonsultansi }}</td>
                                <td class="px-2 py-2 text-center align-middle border border-gray-200">
                                    {{ $jasaLainnya }}</td>
                                <td class="px-2 py-2 text-center align-middle border border-gray-200 font-semibold">
                                    {{ $totalPaket }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($vendor->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                            Menampilkan {{ $vendor->firstItem() }} sampai {{ $vendor->lastItem() }} dari
                            {{ $vendor->total() }} hasil
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{ $vendor->withQueryString()->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div id="excelmodal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full bg-black/30 backdrop-blur-sm">
        <div class="relative w-full max-w-2xl mx-auto h-full flex items-center">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-h-[90vh] overflow-hidden">
                <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-500"></div>
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-green-600 to-teal-600 text-white shadow-sm">
                            <img src="https://img.icons8.com/color/24/000000/ms-excel.png" alt="Excel icon" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Export Data Excel</h3>
                            <p class="text-xs text-slate-500">Unduh data paket pengadaan dalam format Excel</p>
                        </div>
                    </div>
                    <button type="button"
                        class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm p-2 inline-flex items-center transition"
                        data-modal-hide="excelmodal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form method="GET" action="{{ route('exportexcelaporanperpenyedia', request()->query()) }}"
                    class="px-6 py-6 space-y-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                    @foreach (request()->query() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div>
                        <label for="nama_kepala_dinas" class="block mb-2 text-sm font-semibold text-slate-700">Nama
                            Kepala Dinas</label>
                        <input type="text" name="nama_kepala_dinas" id="nama_kepala_dinas" required
                            placeholder="Masukan Nama Kepala Dinas . . ."
                            class="mt-1 block w-full rounded-lg border border-green-200 bg-green-50 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition">
                    </div>
                    <div>
                        <label for="nip_kepala_dinas" class="block mb-2 text-sm font-semibold text-slate-700">NIP
                            Kepala Dinas</label>
                        <input type="text" name="nip_kepala_dinas" id="nip_kepala_dinas" required
                            placeholder="Masukan NIP Kepala Dinas"
                            class="mt-1 block w-full rounded-lg border border-green-200 bg-green-50 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition">
                    </div>
                    <div>
                        <label for="nama_kepala_bidang" class="block mb-2 text-sm font-semibold text-slate-700">Nama
                            Kepala Bidang</label>
                        <input type="text" name="nama_kepala_bidang" id="nama_kepala_bidang" required
                            placeholder="Masukan Nama Kepala Bidang . . ."
                            class="mt-1 block w-full rounded-lg border border-green-200 bg-green-50 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition">
                    </div>
                    <div>
                        <label for="nip_kepala_bidang" class="block mb-2 text-sm font-semibold text-slate-700">NIP
                            Kepala Bidang</label>
                        <input type="text" name="nip_kepala_bidang" id="nip_kepala_bidang" required
                            placeholder="Masukan NIP Kepala Bidang . . ."
                            class="mt-1 block w-full rounded-lg border border-green-200 bg-green-50 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition">
                    </div>
                    <div class="flex justify-end items-center pt-4 border-t border-slate-200 gap-2">
                        <button type="button" data-modal-hide="excelmodal"
                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-green-600 to-teal-600 text-white hover:brightness-110 transition">
                            <i class="fas fa-file-excel mr-2"></i>Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="pdfmodal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full bg-black/30 backdrop-blur-sm">
        <div class="relative w-full max-w-2xl mx-auto h-full flex items-center">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-h-[90vh] overflow-hidden">
                <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-500"></div>
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-red-600 to-pink-600 text-white shadow-sm">
                            <img src="https://img.icons8.com/color/24/000000/pdf.png" alt="PDF icon" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Export Data PDF</h3>
                            <p class="text-xs text-slate-500">Unduh data paket pengadaan dalam format PDF</p>
                        </div>
                    </div>
                    <button type="button"
                        class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm p-2 inline-flex items-center transition"
                        data-modal-hide="pdfmodal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form method="GET" action="{{ route('exportpdflaporanperpenyedia', request()->query()) }}" target="_blank"
                    class="px-6 py-6 space-y-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                    @foreach (request()->query() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div>
                        <label for="nama_kepala_dinas" class="block mb-2 text-sm font-semibold text-slate-700">Nama
                            Kepala Dinas</label>
                        <input type="text" name="nama_kepala_dinas" id="nama_kepala_dinas" required
                            placeholder="Masukan Nama Kepala Dinas . . ."
                            class="mt-1 block w-full rounded-lg border border-red-200 bg-red-50 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm transition">
                    </div>
                    <div>
                        <label for="nip_kepala_dinas" class="block mb-2 text-sm font-semibold text-slate-700">NIP
                            Kepala Dinas</label>
                        <input type="text" name="nip_kepala_dinas" id="nip_kepala_dinas" required
                            placeholder="Masukan NIP Kepala Dinas . . ."
                            class="mt-1 block w-full rounded-lg border border-red-200 bg-red-50 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm transition">
                    </div>
                    <div>
                        <label for="nama_kepala_bidang" class="block mb-2 text-sm font-semibold text-slate-700">Nama
                            Kepala Bidang</label>
                        <input type="text" name="nama_kepala_bidang" id="nama_kepala_bidang" required
                            placeholder="Masukan Nama Kepala Bidang . . ."
                            class="mt-1 block w-full rounded-lg border border-red-200 bg-red-50 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm transition">
                    </div>
                    <div>
                        <label for="nip_kepala_bidang" class="block mb-2 text-sm font-semibold text-slate-700">NIP
                            Kepala Bidang</label>
                        <input type="text" name="nip_kepala_bidang" id="nip_kepala_bidang" required
                            placeholder="Masukan NIP Kepala Bidang . . ."
                            class="mt-1 block w-full rounded-lg border border-red-200 bg-red-50 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm transition">
                    </div>
                    <div class="flex justify-end items-center pt-4 border-t border-slate-200 gap-2">
                        <button type="button" data-modal-hide="pdfmodal"
                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-red-600 to-pink-600 text-white hover:brightness-110 transition">
                            <i class="fas fa-file-pdf mr-2"></i>Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
