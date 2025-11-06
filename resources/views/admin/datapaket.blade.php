<x-app-layout :title="$title" :subtitle="$subtitle ?? ''">
    <div class="px-4 md:px-0 max-w-screen-2xl mx-auto">
        <div
            class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-t-xl shadow-2xl mt-20 overflow-hidden relative">
            <div class="absolute inset-0 bg-gradient-to-r from-white/5 to-transparent"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>

            <div class="relative p-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div class="text-white space-y-2">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-database text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold tracking-tight">{{ $title }}</h2>
                                <p class="text-blue-100 text-xs font-medium">
                                    {{ $subtitle ?? 'Kelola data paket dengan mudah dan efisien' }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('datapaket') }}" method="GET" class="w-full lg:w-auto" id="search-form">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors text-xs"></i>
                                </div>
                                <input type="text" placeholder="Cari nama paket..." name="search"
                                    value="{{ request('search') }}"
                                    class="w-full sm:w-64 h-9 pl-3 pr-3 bg-white/95 backdrop-blur-sm border-0 rounded-lg shadow-lg text-xs placeholder-gray-500 focus:ring-2 focus:ring-white/50 focus:bg-white transition-all duration-300 font-medium">
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        class="fas fa-building text-gray-400 group-focus-within:text-blue-500 transition-colors text-xs"></i>
                                </div>
                                <select name="bidang" onchange="this.form.submit()"
                                    class="h-9 pl-3 pr-3 bg-white/95 backdrop-blur-sm border-0 rounded-lg shadow-lg text-xs focus:ring-2 focus:ring-white/50 focus:bg-white transition-all duration-300 font-medium appearance-none cursor-pointer min-w-[160px] w-full sm:w-auto hover:bg-white group-hover:shadow-xl">
                                    <option value="" class="text-gray-600 bg-white py-2">
                                        Semua Bidang
                                    </option>
                                    @foreach ($bidang as $b)
                                        <option value="{{ $b->nama_bidang }}"
                                            class="text-gray-700 bg-white hover:bg-blue-50 py-2 px-3 border-b border-gray-100 last:border-0"
                                            {{ request('bidang') == $b->nama_bidang ? 'selected' : '' }}>
                                            {{ $b->nama_bidang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit"
                                class="h-9 px-4 bg-white/20 hover:bg-white/30 text-white rounded-lg shadow-lg font-semibold transition-all duration-300 hover:shadow-xl hover:scale-105 backdrop-blur-sm border border-white/20 flex items-center justify-center gap-2 min-w-[80px]">
                                <i class="fas fa-search text-xs"></i>
                                <span class="hidden sm:inline text-xs">Cari</span>
                            </button>
                        </div>

                        @if (request('search') || request('bidang'))
                            <div class="mt-3 flex flex-wrap items-center gap-1">
                                <span class="text-blue-100 text-[10px] font-medium">Filter aktif:</span>
                                @if (request('search'))
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 bg-white/20 text-white text-[10px] rounded-full backdrop-blur-sm">
                                        <i class="fas fa-search text-[8px]"></i>
                                        "{{ request('search') }}"
                                        <a href="{{ route('datapaket', ['bidang' => request('bidang')]) }}"
                                            class="ml-1 hover:text-red-200">
                                            <i class="fas fa-times text-[6px]"></i>
                                        </a>
                                    </span>
                                @endif
                                @if (request('bidang'))
                                    @php
                                        $selectedBidang = $bidang->where('nama_bidang', request('bidang'))->first();
                                    @endphp
                                    @if ($selectedBidang)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 bg-white/20 text-white text-[10px] rounded-full backdrop-blur-sm">
                                            <i class="fas fa-briefcase text-[8px]"></i>
                                            {{ $selectedBidang->nama_bidang }}
                                            <a href="{{ route('datapaket', ['search' => request('search')]) }}"
                                                class="ml-1 hover:text-red-200">
                                                <i class="fas fa-times text-[6px]"></i>
                                            </a>
                                        </span>
                                    @endif
                                @endif
                                <a href="{{ route('datapaket') }}"
                                    class="text-blue-100 hover:text-white text-[10px] underline font-medium transition-colors">
                                    Hapus semua filter
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-2xl rounded-b-xl">
            <div class="block lg:hidden p-6 space-y-4">
                @forelse ($paket as $index => $item)
                    <div
                        class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-sm mb-2">{{ $item->nama_paket }}</h3>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @if ($item->sumber_dana)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200">
                                            <i class="fas fa-coins mr-1"></i>
                                            {{ $item->sumber_dana }}
                                        </span>
                                    @endif
                                    @if ($item->jenis_pengadaan)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full border border-purple-200">
                                            <i class="fas fa-clipboard-list mr-1"></i>
                                            {{ $item->jenis_pengadaan }}
                                        </span>
                                    @endif
                                    @if ($item->metode_pengadaan)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full border border-emerald-200">
                                            <i class="fas fa-cogs mr-1"></i>
                                            {{ $item->metode_pengadaan }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <button data-modal-toggle="edit-modal{{ $item->id }}"
                                data-modal-target="edit-modal{{ $item->id }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg">
                                <i class="fas fa-pencil-alt text-xs"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div class="space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-briefcase mr-2 text-indigo-500 text-xs"></i>
                                    <span class="font-medium">Bidang:</span>
                                </div>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                    {{ $item->bidang ?? 'Belum Ditentukan' }}
                                </span>

                                <div class="flex items-center text-gray-600 mt-3">
                                    <i class="fas fa-building mr-2 text-green-500 text-xs"></i>
                                    <span class="font-medium">Penyedia:</span>
                                </div>
                                <p class="text-gray-800 text-xs">{{ $item->nama_penyedia }}</p>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-money-bill-wave mr-2 text-green-500 text-xs"></i>
                                    <span class="font-medium">Pagu:</span>
                                </div>
                                <p class="text-green-600 font-bold text-xs">
                                    Rp.&nbsp;{{ number_format($item->pagu, 2, ',', '.') }}</p>

                                <div class="flex items-center text-gray-600 mt-3">
                                    <i class="fas fa-tag mr-2 text-orange-500 text-xs"></i>
                                    <span class="font-medium">Status:</span>
                                </div>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $item->oap == 1 ? 'bg-orange-100 text-orange-800' : ($item->oap === 0 ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $item->oap == 1 ? 'OAP' : ($item->oap === 0 ? 'NON OAP' : 'Belum Ditentukan') }}
                                </span>

                                @if ($item->status_tender || $item->status_nontender)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        {{ $item->status_tender ?? $item->status_nontender }}
                                        </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-circle text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Data tidak ditemukan</h3>
                        <p class="text-gray-500 text-xs">Coba gunakan kata kunci pencarian yang berbeda</p>
                    </div>
                @endforelse
            </div>

            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr class="text-gray-700 uppercase text-xs font-bold tracking-wider">
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-hashtag mr-1 text-xs"></i>
                                    No
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-box mr-1 text-xs"></i>
                                    Nama Paket
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-briefcase mr-1 text-xs"></i>
                                    Bidang
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave mr-1 text-xs"></i>
                                    Pagu
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-building mr-1 text-xs"></i>
                                    Penyedia
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                   TYPE
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-info-circle mr-1 text-xs"></i>
                                    Status
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-cog mr-1 text-xs"></i>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $startNumber = $paket->firstItem();
                        @endphp
                        @forelse ($paket as $index => $item)
                            <tr
                                class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 transition-all duration-200">
                                <td class="px-4 py-3 text-xs font-bold text-center text-gray-700">
                                    <div
                                        class="bg-sky-100 text-sky-800 rounded-full w-6 h-6 flex items-center justify-center mx-auto">
                                        {{ $startNumber++ }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    <div class="font-bold text-gray-800 mb-1">{{ $item->nama_paket }}</div>
                                    @if ($item->sumber_dana || $item->jenis_pengadaan || $item->metode_pengadaan)
                                        <div class="flex flex-wrap gap-1">
                                            @if ($item->sumber_dana)
                                                <span
                                                    class="inline-flex items-center px-1 py-0.5 text-[9px] font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200">
                                                    {{ $item->sumber_dana }}
                                                </span>
                                            @endif
                                            @if ($item->jenis_pengadaan)
                                                <span
                                                    class="inline-flex items-center px-1 py-0.5 text-[9px] font-medium bg-purple-100 text-purple-800 rounded-full border border-purple-200">
                                                    {{ $item->jenis_pengadaan }}
                                                </span>
                                            @endif
                                            @if ($item->metode_pengadaan)
                                                <span
                                                    class="inline-flex items-center px-1 py-0.5 text-[9px] font-medium bg-emerald-100 text-emerald-800 rounded-full border border-emerald-200">
                                                    {{ $item->metode_pengadaan }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-center">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium
                        {{ $item->bidang ? 'bg-indigo-100 text-indigo-800 border border-indigo-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                                        {{ $item->bidang ?? 'Belum Ditentukan' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-right">
                                    <div class="font-bold text-green-600">
                                        Rp.&nbsp;{{ number_format($item->pagu, 2, ',', '.') }}</div>
                                </td>
                                <td class="px-4 py-3 text-xs text-center text-gray-700">
                                    {{ $item->nama_penyedia }}
                                </td>
                                <td class="px-4 py-3 text-xs text-center">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium
                                    {{ $item->oap == 1 ? 'bg-orange-100 text-orange-800' : ($item->oap === 0 ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $item->oap == 1 ? 'OAP' : ($item->oap === 0 ? 'NON OAP' : 'Belum Ditentukan') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-center">
                                    @if ($item->status_tender || $item->status_nontender)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-green-100 text-green-800 border border-green-200">
                                            {{ $item->status_tender ?? $item->status_nontender }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center">
                                        <button data-modal-toggle="edit-modal{{ $item->id }}"
                                            data-modal-target="edit-modal{{ $item->id }}" title="Edit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg transform hover:scale-105">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-16 text-center">
                                    <div
                                        class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-exclamation-circle text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Data tidak ditemukan</h3>
                                    <p class="text-gray-500 text-xs">Coba gunakan kata kunci pencarian yang berbeda</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                {{ $paket->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    @foreach ($paket as $item)
        <div id="edit-modal{{ $item->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-2 sm:p-4 overflow-x-hidden overflow-y-auto md:inset-0 bg-black/50 backdrop-blur-sm max-h-screen">
            <div class="relative w-full max-w-6xl max-h-full mx-auto mt-4 sm:mt-8">
                <div
                    class="relative bg-white rounded-2xl shadow-2xl border border-gray-100/50 overflow-hidden max-h-[95vh] flex flex-col">
                    <div
                        class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b border-gray-100/60 p-3 sm:p-4 flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div
                                    class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                    <i class="fas fa-edit text-white text-xs sm:text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs sm:text-sm font-bold text-gray-800 tracking-tight">Detail & Edit
                                        Paket</h3>
                                    <p class="text-[10px] sm:text-xs text-gray-500 mt-0.5 hidden sm:block">Lihat detail
                                        dan perbarui informasi paket
                                        {{ $item->nama_paket }}</p>
                                </div>
                            </div>
                            <button type="button"
                                class="w-6 h-6 sm:w-8 sm:h-8 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md"
                                data-modal-hide="edit-modal{{ $item->id }}">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="p-3 sm:p-6 overflow-y-auto flex-1">
                        <div class="mb-4 sm:mb-6">
                            <h4 class="text-xs sm:text-sm font-bold text-gray-800 mb-2 sm:mb-3 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-1 sm:mr-2 text-xs"></i>
                                Informasi Dasar
                            </h4>
                            <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-200">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3 text-xs">
                                    <div class="mb-2 sm:mb-0">
                                        <span class="text-gray-600 block">Nama Paket:</span>
                                        <p class="font-medium text-gray-800 break-words">{{ $item->nama_paket }}</p>
                                    </div>
                                    <div class="mb-2 sm:mb-0">
                                        <span class="text-gray-600 block">Bidang:</span>
                                        <p class="text-gray-800">{{ $item->bidang ?? 'Belum Ditentukan' }}</p>
                                    </div>
                                    <div class="mb-2 sm:mb-0">
                                        <span class="text-gray-600 block">Pagu:</span>
                                        <p class="font-bold text-green-600 break-words">Rp
                                            {{ number_format($item->pagu, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="mb-2 sm:mb-0">
                                        <span class="text-gray-600 block">Jenis:</span>
                                        <p class="text-gray-800">{{ $item->jenis_pengadaan ?? '-' }}</p>
                                    </div>
                                    <div class="mb-2 sm:mb-0">
                                        <span class="text-gray-600 block">Metode:</span>
                                        <p class="text-gray-800">{{ $item->metode_pengadaan ?? '-' }}</p>
                                    </div>
                                    <div class="mb-2 sm:mb-0">
                                        <span class="text-gray-600 block">Status:</span>
                                        <span
                                            class="px-2 py-1 text-[10px] sm:text-xs rounded inline-block {{ $item->oap == 1 ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $item->oap == 1 ? 'OAP' : 'NON OAP' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('editpaket', ['id' => encrypt($item->id)]) }}" method="post">
                            @csrf
                            <div class="space-y-4 sm:space-y-6">
                                <div>
                                    <h4
                                        class="text-xs sm:text-sm font-bold text-gray-800 mb-2 sm:mb-3 flex items-center">
                                        <i class="fas fa-briefcase text-indigo-500 mr-1 sm:mr-2 text-xs"></i>
                                        Informasi Paket
                                    </h4>
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 bg-indigo-50/50 rounded-lg p-3 sm:p-4 border border-indigo-100">
                                        <div class="space-y-1">
                                            <label for="bidang{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-briefcase text-indigo-500 mr-1 text-xs"></i>
                                                Bidang
                                            </label>
                                            <select name="bidang" id="bidang{{ $item->id }}"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 text-xs">
                                                <option value="">Pilih Bidang</option>
                                                @foreach ($bidang as $b)
                                                    <option value="{{ $b->nama_bidang }}"
                                                        {{ old('bidang', $item->bidang) == $b->nama_bidang ? 'selected' : '' }}>
                                                        {{ $b->nama_bidang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-1">
                                            <label for="sumber_dana{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-coins text-green-500 mr-1 text-xs"></i>
                                                Sumber Dana
                                            </label>
                                            <select name="sumber_dana" id="sumber_dana{{ $item->id }}"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 text-xs">
                                                <option value="">Pilih Sumber Dana</option>
                                                <option value="DAK"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DAK' ? 'selected' : '' }}>
                                                    DAK</option>
                                                <option value="DAU"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DAU' ? 'selected' : '' }}>
                                                    DAU</option>
                                                <option value="DTU"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DTU' ? 'selected' : '' }}>
                                                    DTU</option>
                                                <option value="OTSUS 1,25%"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'OTSUS 1,25%' ? 'selected' : '' }}>
                                                    OTSUS 1,25%</option>
                                                <option value="OTSUS 1%"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'OTSUS 1%' ? 'selected' : '' }}>
                                                    OTSUS 1%</option>
                                                <option value="DTI"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DTI' ? 'selected' : '' }}>
                                                    DTI</option>
                                                <option value="DBH MIGAS OTSUS"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DBH MIGAS OTSUS' ? 'selected' : '' }}>
                                                    DBH MIGAS OTSUS</option>
                                                <option value="DAU YANG DITENTUKAN"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DAU YANG DITENTUKAN' ? 'selected' : '' }}>
                                                    DAU YANG DITENTUKAN</option>
                                                <option value="DAK NON FISIK"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DAK NON FISIK' ? 'selected' : '' }}>
                                                    DAK NON FISIK</option>
                                                <option value="PAD"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'PAD' ? 'selected' : '' }}>
                                                    PAD</option>
                                                <option value="DBH PUSAT"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DBH PUSAT' ? 'selected' : '' }}>
                                                    DBH PUSAT</option>
                                                <option value="DBH PAJAK PROVINSI"
                                                    {{ old('sumber_dana', $item->sumber_dana) == 'DBH PAJAK PROVINSI' ? 'selected' : '' }}>
                                                    DBH PAJAK PROVINSI</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4
                                        class="text-xs sm:text-sm font-bold text-gray-800 mb-2 sm:mb-3 flex items-center">
                                        <i class="fas fa-file-contract text-purple-500 mr-1 sm:mr-2 text-xs"></i>
                                        Informasi Kontrak
                                    </h4>
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 bg-purple-50/50 rounded-lg p-3 sm:p-4 border border-purple-100">
                                        <div class="space-y-1">
                                            <label for="no_kontrak{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-file-contract text-blue-500 mr-1 text-xs"></i>
                                                No. Kontrak
                                            </label>
                                            <input type="text" name="no_kontrak"
                                                id="no_kontrak{{ $item->id }}"
                                                value="{{ old('no_kontrak', $item->no_kontrak) }}"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-200 text-xs" />
                                        </div>

                                        <div class="space-y-1">
                                            <label for="tgl_kontrak{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-calendar text-purple-500 mr-1 text-xs"></i>
                                                Tanggal Kontrak
                                            </label>
                                            <input type="date" name="tgl_kontrak"
                                                id="tgl_kontrak{{ $item->id }}"
                                                value="{{ old('tgl_kontrak', $item->tgl_kontrak) }}"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-200 text-xs" />
                                        </div>

                                        <div class="space-y-1">
                                            <label for="waktu_pelaksanaan{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-clock text-indigo-500 mr-1 text-xs"></i>
                                                Waktu Pelaksanaan
                                            </label>
                                            <input type="text" name="waktu_pelaksanaan"
                                                id="waktu_pelaksanaan{{ $item->id }}"
                                                value="{{ old('waktu_pelaksanaan', $item->waktu_pelaksanaan) }}"
                                                placeholder="Contoh: 90 hari kalender"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all duration-200 text-xs" />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4
                                        class="text-xs sm:text-sm font-bold text-gray-800 mb-2 sm:mb-3 flex items-center">
                                        <i class="fas fa-money-bill-wave text-green-500 mr-1 sm:mr-2 text-xs"></i>
                                        Informasi Finansial
                                    </h4>
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 bg-green-50/50 rounded-lg p-3 sm:p-4 border border-green-100">
                                        <div class="space-y-1">
                                            <label for="nilai_kontrak{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-money-bill-wave text-green-500 mr-1 text-xs"></i>
                                                Nilai Kontrak
                                            </label>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-2 sm:left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                                <input type="text" name="nilai_kontrak"
                                                    id="nilai_kontrak{{ $item->id }}"
                                                    value="{{ old('nilai_kontrak', number_format($item->nilai_kontrak ?? 0, 0, ',', '.')) }}"
                                                    placeholder="0"
                                                    class="w-full pl-6 sm:pl-8 pr-2 sm:pr-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-xs currency-input" />
                                            </div>
                                        </div>

                                        <div class="space-y-1">
                                            <label for="nilai_penawaran{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-hand-holding-usd text-orange-500 mr-1 text-xs"></i>
                                                Nilai Penawaran
                                            </label>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-2 sm:left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                                <input type="text" name="nilai_penawaran"
                                                    id="nilai_penawaran{{ $item->id }}"
                                                    value="{{ old('nilai_penawaran', number_format($item->nilai_penawaran ?? 0, 0, ',', '.')) }}"
                                                    placeholder="0"
                                                    class="w-full pl-6 sm:pl-8 pr-2 sm:pr-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-xs currency-input" />
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                document.querySelectorAll('.currency-input').forEach(function(input) {
                                                    input.addEventListener('input', function(e) {
                                                        let value = e.target.value.replace(/[^\d]/g, '');
                                                        if (value) {
                                                            e.target.value = new Intl.NumberFormat('id-ID').format(value);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                        @if ($item->pagu && $item->nilai_kontrak)
                                            <div class="md:col-span-2 bg-white rounded-lg p-3 border border-green-200">
                                                <h5 class="text-xs font-semibold text-gray-700 mb-2 flex items-center">
                                                    <i class="fas fa-calculator text-blue-500 mr-1 text-xs"></i>
                                                    Analisis Efisiensi
                                                </h5>
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3 text-xs">
                                                    <div class="mb-2 sm:mb-0">
                                                        <span class="text-gray-600 block">Pagu Anggaran:</span>
                                                        <p class="font-semibold text-blue-600 break-words">
                                                            Rp.&nbsp;{{ number_format($item->pagu, 0, ',', '.') }}</p>
                                                    </div>
                                                    <div class="mb-2 sm:mb-0">
                                                        <span class="text-gray-600 block">Nilai Kontrak:</span>
                                                        <p class="font-semibold text-green-600 break-words">
                                                            Rp.&nbsp;{{ number_format($item->nilai_kontrak ?? 0, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-600 block">Efisiensi:</span>
                                                        @php
                                                            $efisiensi =
                                                                $item->pagu > 0
                                                                    ? (($item->pagu - ($item->nilai_kontrak ?? 0)) /
                                                                            $item->pagu) *
                                                                        100
                                                                    : 0;
                                                        @endphp
                                                        <p
                                                            class="font-semibold {{ $efisiensi >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ number_format($efisiensi, 2) }}%
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <h4
                                        class="text-xs sm:text-sm font-bold text-gray-800 mb-2 sm:mb-3 flex items-center">
                                        <i class="fas fa-building text-blue-500 mr-1 sm:mr-2 text-xs"></i>
                                        Informasi Penyedia
                                    </h4>
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 bg-blue-50/50 rounded-lg p-3 sm:p-4 border border-blue-100">
                                        <div class="space-y-1">
                                            <label for="nama_penyedia{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-building text-blue-500 mr-1 text-xs"></i>
                                                Nama Penyedia
                                            </label>
                                            <input type="text" name="nama_penyedia"
                                                id="nama_penyedia{{ $item->id }}"
                                                value="{{ old('nama_penyedia', $item->nama_penyedia) }}"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-xs" />
                                        </div>

                                        <div class="space-y-1">
                                            <label for="npwp_penyedia{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-id-card text-red-500 mr-1 text-xs"></i>
                                                NPWP Penyedia
                                            </label>
                                            <input type="text" name="npwp_penyedia"
                                                id="npwp_penyedia{{ $item->id }}"
                                                value="{{ old('npwp_penyedia', $item->npwp_penyedia) }}"
                                                placeholder="43.643.774.3-952.000"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-xs npwp-input"
                                                maxlength="20" />

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    function formatNPWP(value) {
                                                        // Remove all non-digit characters
                                                        let digits = value.replace(/[^\d]/g, '');

                                                        // Limit to 15 digits
                                                        digits = digits.substring(0, 15);

                                                        // Apply NPWP formatting
                                                        let formatted = '';
                                                        if (digits.length > 0) {
                                                            formatted = digits.substring(0, 2);
                                                            if (digits.length > 2) {
                                                                formatted += '.' + digits.substring(2, 5);
                                                                if (digits.length > 5) {
                                                                    formatted += '.' + digits.substring(5, 8);
                                                                    if (digits.length > 8) {
                                                                        formatted += '.' + digits.substring(8, 9);
                                                                        if (digits.length > 9) {
                                                                            formatted += '-' + digits.substring(9, 12);
                                                                            if (digits.length > 12) {
                                                                                formatted += '.' + digits.substring(12, 15);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        return formatted;
                                                    }

                                                    document.querySelectorAll('.npwp-input').forEach(function(input) {
                                                        // Format existing value on page load
                                                        if (input.value) {
                                                            input.value = formatNPWP(input.value);
                                                        }

                                                        input.addEventListener('input', function(e) {
                                                            let cursorPosition = e.target.selectionStart;
                                                            let oldValue = e.target.value;
                                                            let formatted = formatNPWP(e.target.value);

                                                            e.target.value = formatted;

                                                            // Adjust cursor position
                                                            if (formatted.length > oldValue.length) {
                                                                cursorPosition++;
                                                            }

                                                            e.target.setSelectionRange(cursorPosition, cursorPosition);
                                                        });

                                                        input.addEventListener('keydown', function(e) {
                                                            // Allow: backspace, delete, tab, escape, enter
                                                            if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                                                                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                                                                (e.keyCode === 65 && e.ctrlKey === true) ||
                                                                (e.keyCode === 67 && e.ctrlKey === true) ||
                                                                (e.keyCode === 86 && e.ctrlKey === true) ||
                                                                (e.keyCode === 88 && e.ctrlKey === true)) {
                                                                return;
                                                            }
                                                            // Ensure that it is a number and stop the keypress
                                                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e
                                                                    .keyCode > 105)) {
                                                                e.preventDefault();
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                        </div>

                                        <div class="space-y-1 md:col-span-2">
                                            <label for="wakil_sah_penyedia{{ $item->id }}"
                                                class="flex items-center text-xs font-semibold text-gray-700">
                                                <i class="fas fa-user-tie text-gray-500 mr-1 text-xs"></i>
                                                Wakil Sah Penyedia
                                            </label>
                                            <input type="text" name="wakil_sah_penyedia"
                                                id="wakil_sah_penyedia{{ $item->id }}"
                                                value="{{ old('wakil_sah_penyedia', $item->wakil_sah_penyedia) }}"
                                                class="w-full px-2 sm:px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-xs" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <div
                        class="bg-gradient-to-r from-gray-50 to-blue-50/30 border-t border-gray-100/60 px-3 sm:px-6 py-3 sm:py-4 flex-shrink-0">
                        <div
                            class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                            <button type="button" data-modal-hide="edit-modal{{ $item->id }}"
                                class="w-full sm:w-auto px-3 sm:px-4 py-2 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg font-medium text-xs transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-times mr-1 text-xs"></i>
                                Tutup
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-medium text-xs transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-1 text-xs"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
