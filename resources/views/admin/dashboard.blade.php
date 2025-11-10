<x-app-layout :title="$title" :subtitle="$subtitle ?? ''" :active="$active">
    <div class="px-4 md:px-0 max-w-screen-2xl mx-auto mt-20">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-6 rounded-lg shadow-md mb-8 relative overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
                <div>
                    <h2 class="text-base font-semibold text-gray-800">Dashboard Overview</h2>
                    <p class="text-xs text-gray-600 mt-1">Monitor statistik dan aktivitas sistem</p>
                </div>
                <form action="{{ route('dashboard') }}" method="get">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative">
                            <select name="bidang" id="bidang"
                                class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm text-sm">
                                <option value="">Pilih Bidang</option>
                                @foreach ($bidanglist as $bidang)
                                    <option value="{{ $bidang->nama_bidang }}" {{ request('bidang') == $bidang->nama_bidang ? 'selected' : '' }}>{{ $bidang->nama_bidang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <select name="tahun_anggaran" id="tahun_anggaran"
                                class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm text-sm">
                                <option value="">Pilih Tahun Anggaran</option>
                                @foreach ($tahunanggaran as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun_anggaran') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="filterButton" type="submit"
                            class="bg-linear-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </form>
            </div>
            <div class="absolute -bottom-2 -right-2 opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div
                class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500 group relative overflow-hidden">
                <div class="flex items-center relative z-10">
                    <div
                        class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 mb-1">Total Paket</p>
                        <p class="text-xl font-bold text-gray-900 mb-1">{{ $totalpaket }}</p>
                    </div>
                </div>
                <div class="absolute -bottom-2 -right-2 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7" />
                    </svg>
                </div>
            </div>

            <div
                class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500 group relative overflow-hidden">
                <div class="flex items-center relative z-10">
                    <div
                        class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 mb-1">Pengadaan Barang</p>
                        <p class="text-xl font-bold text-gray-900 mb-1">{{ $totalpengadaan }}</p>
                    </div>
                </div>
                <div class="absolute -bottom-2 -right-2 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>

            <div
                class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-orange-500 group relative overflow-hidden">
                <div class="flex items-center relative z-10">
                    <div
                        class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3-2 3 2 3-2 3 2zM10 8h4m-4 4h4" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 mb-1">Pekerjaan Konstruksi</p>
                        <p class="text-xl font-bold text-gray-900 mb-1">{{ $totalkonstruksi }}</p>
                    </div>
                </div>
                <div class="absolute -bottom-2 -right-2 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-orange-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3-2 3 2 3-2 3 2zM10 8h4m-4 4h4" />
                    </svg>
                </div>
            </div>

            <div
                class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-yellow-500 group relative overflow-hidden">
                <div class="flex items-center relative z-10">
                    <div
                        class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-3 rounded-xl text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 mb-1">Jasa Konsultansi</p>
                        <p class="text-xl font-bold text-gray-900 mb-1">{{ $totalkonsultansi }}</p>
                    </div>
                </div>
                <div class="absolute -bottom-2 -right-2 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

            <div
                class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-purple-500 group relative overflow-hidden">
                <div class="flex items-center relative z-10">
                    <div
                        class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl text-white shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 mb-1">Jasa Lainnya</p>
                        <p class="text-xl font-bold text-gray-900 mb-1">{{ $totallainnya }}</p>
                    </div>
                </div>
                <div class="absolute -bottom-2 -right-2 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-3 rounded-2xl text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Data Penyedia</h3>
                        <p class="text-sm text-gray-600">Distribusi penyedia berdasarkan kategori</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="space-y-4">
                    <div
                        class="bg-gradient-to-r from-slate-50 to-slate-100 p-4 rounded-2xl border-2 border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-3 h-3 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full shadow-md">
                                </div>
                                <span class="text-sm font-semibold text-slate-700">Total Penyedia</span>
                            </div>
                            <span class="text-2xl font-bold text-slate-800">{{ $totalpenyedia }}</span>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-emerald-50 to-emerald-100 p-4 rounded-2xl border-2 border-emerald-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full shadow-md"></div>
                                <span class="text-sm font-semibold text-slate-700">Orang Asli Papua</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xl font-bold text-emerald-700">{{ $totalpenyediaoap }}</span>
                                <span class="block text-xs text-emerald-600 font-medium">
                                    @php
                                        $percentageOAP =
                                            $totalpenyedia > 0 ? ($totalpenyediaoap / $totalpenyedia) * 100 : 0;
                                        echo number_format($percentageOAP, 2) . '%';
                                    @endphp
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-amber-50 to-amber-100 p-4 rounded-2xl border-2 border-amber-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-amber-500 rounded-full shadow-md"></div>
                                <span class="text-sm font-semibold text-slate-700">Bukan Orang Asli Papua</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xl font-bold text-amber-700">{{ $totalpenyedianonoap }}</span>
                                <span class="block text-xs text-amber-600 font-medium">
                                    @php
                                        $percentageNonOAP =
                                            $totalpenyedia > 0 ? ($totalpenyedianonoap / $totalpenyedia) * 100 : 0;
                                        echo number_format($percentageNonOAP, 2) . '%';
                                    @endphp
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="relative">
                        <div id="penyedia-chart" class="drop-shadow-xl"></div>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="text-center bg-white/90 backdrop-blur-sm px-3 py-2 rounded-xl shadow-lg">
                                <div class="text-2xl font-bold text-slate-800">{{ $totalpenyedia }}</div>
                                <div class="text-xs text-slate-600 font-medium">Total Penyedia</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200 mt-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-violet-500 to-purple-600 p-3 rounded-2xl text-white shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14-16H9m10 16H7m3-8h2.586a1 1 0 00.707-.293l2.414-2.414A1 1 0 0016 11V9a1 1 0 00-1-1h-4a1 1 0 00-1 1v2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Top 10 Penyedia</h3>
                        <p class="text-sm text-gray-600">Penyedia dengan jumlah paket terbanyak</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-100">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Rank</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Nama Penyedia</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm">Jenis Penyedia</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-700 text-sm">Jumlah Paket</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-700 text-sm">Tender</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-700 text-sm">Non Tender</th>

                            <th class="text-center py-3 px-4 font-semibold text-gray-700 text-sm">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($toppenyedia as $index => $penyedia)
                            <tr class="border-b border-gray-50 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-gray-900 text-sm">{{ $penyedia->nama_penyedia }}</div>
                                    <div class="text-xs text-gray-500">{{ $penyedia->oap == 1 ? 'Orang Asli Papua' : 'Bukan Orang Asli Papua' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="bg-{{ $penyedia->oap == 1 ? 'emerald' : 'amber' }}-100 text-{{ $penyedia->oap == 1 ? 'emerald' : 'amber' }}-800 text-xs font-medium px-2 py-1 rounded-full">
                                        {{ $penyedia->oap == 1 ? 'OAP' : 'Non-OAP' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="text-lg font-bold text-blue-600">{{ $penyedia->jumlah_paket }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="text-lg font-bold text-blue-600">{{ $penyedia->tender_count}}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="text-lg font-bold text-blue-600">{{ $penyedia->non_tender_count }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="text-sm font-semibold text-green-600">Rp {{ number_format($penyedia->total_nilai / 1000000, 1) }}M</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-sm">Tidak ada data penyedia tersedia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200 mt-8">
            <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-indigo-500 to-blue-600 p-3 rounded-2xl text-white shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2-2m0 0V5a2 2 0 012-2h12a2 2 0 012 2v2M7 7h10" />
            </svg>
            </div>
            <div>
            <h3 class="text-lg font-bold text-gray-900">Data Bidang Pengadaan</h3>
            <p class="text-sm text-gray-600">Distribusi pengadaan berdasarkan bidang dan jenis</p>
            </div>
            </div>
            </div>

            <div class="overflow-x-auto">
            <table class="w-full border border-gray-300">
            <thead>
            <tr class="border-b-2 border-gray-300 bg-gray-100">
                <th rowspan="2"
                class="text-left py-3 px-4 font-semibold text-gray-700 border-r border-gray-300 text-sm">
                No</th>
                <th rowspan="2"
                class="text-left py-3 px-4 font-semibold text-gray-700 border-r border-gray-300 text-sm">
                Bidang</th>
                <th colspan="4"
                class="text-center py-3 px-4 font-semibold text-gray-700 border-b border-gray-300 text-sm">
                Jenis Pengadaan</th>
                <th rowspan="2"
                class="text-center py-3 px-4 font-semibold text-gray-700 border-l border-gray-300 text-sm">
                Total Paket</th>
                <th rowspan="2"
                class="text-center py-3 px-4 font-semibold text-gray-700 border-l border-gray-300 text-sm">
                Total Pagu</th>
            </tr>
            <tr class="border-b border-gray-300 bg-gray-50">
                <th
                class="text-center py-2 px-2 font-medium text-gray-600 text-xs border-r border-gray-300">
                Pengadaan Barang</th>
                <th
                class="text-center py-2 px-2 font-medium text-gray-600 text-xs border-r border-gray-300">
                Pekerjaan Konstruksi</th>
                <th
                class="text-center py-2 px-2 font-medium text-gray-600 text-xs border-r border-gray-300">
                Jasa Konsultansi</th>
                <th class="text-center py-2 px-2 font-medium text-gray-600 text-xs">Jasa Lainnya</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($bidangpaket as $index => $bidang)
                <tr
                class="border-b border-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span
                class="w-5 h-5 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                </td>
                <td class="py-3 px-4 border-r border-gray-300">
                <div class="font-semibold text-gray-900 text-sm">{{ $bidang->nama_bidang }}</div>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-xs font-medium text-green-600">{{ $bidang->barang }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-xs font-medium text-blue-600">{{ $bidang->pekerjaan_konstruksi }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-xs font-medium text-yellow-600">{{ $bidang->jasa_konsultansi }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-xs font-medium text-purple-600">{{ $bidang->jasa_lainnya }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-lg font-bold text-blue-600">{{ $bidang->total_paket }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-sm font-semibold text-green-600">Rp {{ number_format($bidang->total_pagu / 1000000, 1) }}M</span>
                </td>
                </tr>
            @empty
                <tr>
                <td colspan="8" class="py-8 text-center text-gray-500">
                <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2-2m0 0V5a2 2 0 012-2h12a2 2 0 012 2v2M7 7h10" />
                </svg>
                <p class="text-sm">Tidak ada data bidang tersedia</p>
                </div>
                </td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr class="border-t-2 border-gray-400 bg-gray-100">
                <td colspan="2"
                class="py-3 px-4 text-right font-bold text-gray-700 border-r border-gray-300 text-sm">
                Total Keseluruhan:</td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-sm font-bold text-green-600">{{ $bidangpaket->sum('barang') }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-sm font-bold text-blue-600">{{ $bidangpaket->sum('pekerjaan_konstruksi') }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-sm font-bold text-yellow-600">{{ $bidangpaket->sum('jasa_konsultansi') }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-sm font-bold text-purple-600">{{ $bidangpaket->sum('jasa_lainnya') }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-lg font-bold text-indigo-600">{{ $bidangpaket->sum('total_paket') }}</span>
                </td>
                <td class="py-3 px-4 text-center border-r border-gray-300">
                <span class="text-lg font-bold text-green-600">Rp {{ number_format($bidangpaket->sum('total_pagu') / 1000000, 1) }}M</span>
                </td>
            </tr>
            </tfoot>
            </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{{ $totalpenyediaoap }}, {{ $totalpenyedianonoap }}],
                labels: ['Orang Asli Papua', 'Bukan Orang Asli Papua'],
                chart: {
                    type: 'donut',
                    width: 300,
                    height: 300
                },
                colors: ['#10B981', '#F59E0B'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: false
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return Math.round(val) + "%"
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold',
                        colors: ['#fff']
                    },
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 2,
                        blur: 2,
                        opacity: 0.9
                    }
                },
                legend: {
                    show: false
                },
                stroke: {
                    width: 3,
                    colors: ['#fff']
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 250,
                            height: 250
                        }
                    }
                }],
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Inter, sans-serif'
                    }
                }
            };

            var chart = new window.ApexCharts(document.querySelector("#penyedia-chart"), options);
            chart.render();
        });
    </script>
</x-app-layout>
