<x-app-layout :title="$title" :subtitle="$subtitle ?? ''">
    <div class="px-4 md:px-6 lg:px-8 max-w-screen-2xl mx-auto">
        <div
            class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-t-xl shadow-2xl mt-20 overflow-hidden relative">
            <div class="absolute inset-0 bg-gradient-to-r from-white/5 to-transparent"></div>
            <div
                class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white/5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32">
            </div>
            <div
                class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white/5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24">
            </div>

            <div class="relative p-4 md:p-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 lg:gap-6">
                    <div class="text-white space-y-2">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-building text-sm"></i>
                            </div>
                            <div>
                                <h2 class="text-lg md:text-xl font-bold tracking-tight">{{ $title }}</h2>
                                <p class="text-blue-100 text-xs font-medium">
                                    {{ $subtitle ?? 'Kelola data penyedia dengan mudah dan efisien' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-auto lg:min-w-[400px]">
                        <form action="{{ route('datapenyedia') }}" method="GET" class="flex items-center gap-2"
                            id="search-form">
                            <div class="relative group flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i
                                        class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors text-xs"></i>
                                </div>
                                <input type="text" placeholder="Cari nama penyedia..." name="search"
                                    value="{{ request('search') }}"
                                    class="w-full h-9 pl-9 pr-3 bg-white/95 backdrop-blur-sm border-0 rounded-lg shadow-lg text-xs placeholder-gray-500 focus:ring-2 focus:ring-white/50 focus:bg-white transition-all duration-300 font-medium">
                            </div>
                            <button type="submit"
                                class="h-9 px-3 bg-white/20 hover:bg-white/30 text-white rounded-lg shadow-lg font-semibold transition-all duration-300 hover:shadow-xl hover:scale-105 backdrop-blur-sm border border-white/20 flex items-center justify-center gap-1 min-w-[70px] flex-shrink-0">
                                <i class="fas fa-search text-xs"></i>
                                <span class="hidden sm:inline text-xs">Cari</span>
                            </button>
                        </form>

                        @if (request('search'))
                            <div class="mt-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-blue-100 text-xs font-medium">Filter aktif:</span>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 bg-white/20 text-white text-xs rounded-full backdrop-blur-sm">
                                        <i class="fas fa-search text-xs"></i>
                                        "{{ request('search') }}"
                                        <a href="{{ route('datapenyedia') }}"
                                            class="ml-1 hover:text-red-200 transition-colors">
                                            <i class="fas fa-times text-xs"></i>
                                        </a>
                                    </span>
                                    <a href="{{ route('datapenyedia') }}"
                                        class="text-blue-100 hover:text-white text-xs underline font-medium transition-colors">
                                        Hapus filter
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border-l-4 border-l-blue-500 shadow-lg">
            <div class="p-4 md:p-5">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-sync-alt text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Sinkronisasi Data Penyedia</h3>
                            <p class="text-xs text-gray-600">Sinkronkan data penyedia dari sistem eksternal</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                        <form action="{{ route('syncdatapenyedia') }}" method="post">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center gap-1 px-3 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-xs font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 min-w-[140px] w-full sm:w-auto">
                                <i class="fas fa-box text-xs"></i>
                                Sync dari Paket
                            </button>
                        </form>

                        <form action="{{ route('syncdatapenyediasikap') }}" method="post">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center gap-1 px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-xs font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 min-w-[140px] w-full sm:w-auto">
                                <i class="fas fa-clipboard-list text-xs"></i>
                                Sync dari SIKAP
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-2xl rounded-b-xl">
            <div class="block lg:hidden p-6 space-y-4">
                @forelse ($penyedia as $index => $item)
                    <div
                        class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-sm mb-2">{{ $item->nama_penyedia }}</h3>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @if ($item->kd_penyedia)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200">
                                            <i class="fas fa-hashtag mr-1"></i>
                                            {{ $item->kd_penyedia }}
                                        </span>
                                    @endif
                                    @if ($item->bentuk_usaha)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full border border-purple-200">
                                            <i class="fas fa-building mr-1"></i>
                                            {{ $item->bentuk_usaha }}
                                        </span>
                                    @endif
                                    @if ($item->oap === 1)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full border border-green-200">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            OAP
                                        </span>
                                    @elseif($item->oap === 0)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full border border-red-200">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Non OAP
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full border border-yellow-200">
                                            <i class="fas fa-question-circle mr-1"></i>
                                            Belum Ditentukan
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button data-modal-target="detailModal" data-modal-toggle="detailModal"
                                    data-item="{{ json_encode($item) }}"
                                    class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded-lg transition-all duration-200">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                <button data-modal-target="editOapModal" data-modal-toggle="editOapModal"
                                    data-item="{{ json_encode($item) }}"
                                    data-action="{{ route('editpenyedia', ['id' => encrypt($item->id)]) }}"
                                    class="text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 px-2 py-1 rounded-lg transition-all duration-200">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <form action="{{ route('syncpenyediasikap') }}" method="post" class="inline">
                                    @csrf
                                    <input type="hidden" name="npwp_penyedia" value="{{ $item->npwp_penyedia }}">
                                    <button type="submit"
                                        class="text-orange-600 hover:text-orange-800 bg-orange-50 hover:bg-orange-100 px-2 py-1 rounded-lg transition-all duration-200"
                                        title="Sync data untuk NPWP {{ $item->npwp_penyedia }}">
                                        <i class="fas fa-sync text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div class="space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-id-card mr-2 text-indigo-500 text-xs"></i>
                                    <span class="font-medium">NPWP:</span>
                                </div>
                                <p class="text-gray-800 text-xs">{{ $item->npwp_penyedia ?? '-' }}</p>

                                <div class="flex items-center text-gray-600 mt-3">
                                    <i class="fas fa-phone mr-2 text-green-500 text-xs"></i>
                                    <span class="font-medium">Telepon:</span>
                                </div>
                                <p class="text-gray-800 text-xs">{{ $item->telepon ?? '-' }}</p>
                            </div>

                            <div class="space-y-2">
                                @if ($item->alamat || $item->kabupaten_kota || $item->provinsi)
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-2 text-orange-500 text-xs"></i>
                                        <span class="font-medium">Alamat:</span>
                                    </div>
                                    <p class="text-gray-800 text-xs">
                                        {{ $item->alamat ? $item->alamat : '' }}{{ $item->alamat && ($item->kabupaten_kota || $item->provinsi) ? ', ' : '' }}{{ $item->kabupaten_kota ? $item->kabupaten_kota : '' }}{{ $item->kabupaten_kota && $item->provinsi ? ', ' : '' }}{{ $item->provinsi ? $item->provinsi : '' }}
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
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Belum ada data penyedia</h3>
                        <p class="text-gray-500 text-xs">Silakan sinkronisasi data untuk memulai</p>
                    </div>
                @endforelse
            </div>

            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-100">
                        <tr class="text-gray-700 uppercase text-xs font-bold tracking-wider">
                            <th class="px-3 py-3 text-center border-b border-gray-200 w-12">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-hashtag mr-1 text-xs"></i>
                                    No
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fas fa-building mr-1 text-xs"></i>
                                    Nama Penyedia
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fas fa-id-card mr-1 text-xs"></i>
                                    NPWP
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-1 text-xs"></i>
                                    Telepon
                                </div>
                            </th>
                            <th class="px-3 py-3 text-center border-b border-gray-200 w-28">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                    Status OAP
                                </div>
                            </th>
                            <th class="px-3 py-3 text-center border-b border-gray-200 w-24">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-cog mr-1 text-xs"></i>
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="penyediaTableBody">
                        @forelse ($penyedia as $index => $item)
                            <tr data-penyedia="{{ strtolower($item->nama_penyedia) }}"
                                class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 transition-all duration-200">
                                <td class="px-3 py-3 text-xs font-bold text-center text-gray-700">
                                    <div
                                        class="bg-sky-100 text-sky-800 rounded-full w-6 h-6 flex items-center justify-center mx-auto font-semibold text-xs">
                                        {{ $penyedia->firstItem() + $loop->index }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-left">
                                    <div class="font-semibold text-gray-800 hover:text-blue-600 transition-colors">
                                        {{ $item->nama_penyedia }}
                                        @if ($item->kd_penyedia)
                                            <span class="text-xs text-blue-600 mt-1 font-mono">
                                                <i class="fas fa-hashtag mr-1"></i>{{ $item->kd_penyedia }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($item->bentuk_usaha)
                                        <div class="text-xs text-purple-600 mt-1">
                                            <i class="fas fa-building mr-1"></i>
                                            {{ $item->bentuk_usaha }}
                                        </div>
                                    @endif
                                    @if ($item->alamat || $item->kabupaten_kota || $item->provinsi)
                                        <div class="text-xs text-gray-600 mt-1">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $item->alamat ? $item->alamat : '' }}{{ $item->alamat && ($item->kabupaten_kota || $item->provinsi) ? ', ' : '' }}{{ $item->kabupaten_kota ? $item->kabupaten_kota : '' }}{{ $item->kabupaten_kota && $item->provinsi ? ', ' : '' }}{{ $item->provinsi ? $item->provinsi : '' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-left">
                                    <div class="font-medium text-gray-700">
                                        {{ $item->npwp_penyedia ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-left">
                                    <div class="font-medium text-gray-700">
                                        {{ $item->telepon ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        @if ($item->oap === 1)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                OAP
                                            </span>
                                        @elseif($item->oap === 0)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Non OAP
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-question-circle mr-1"></i>
                                                Belum Ditentukan
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button data-modal-target="detailModal" data-modal-toggle="detailModal"
                                            data-item="{{ json_encode($item) }}"
                                            class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded-lg transition-all duration-200">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button data-modal-target="editOapModal" data-modal-toggle="editOapModal"
                                            data-item="{{ json_encode($item) }}"
                                            data-action="{{ route('editpenyedia', ['id' => encrypt($item->id)]) }}"
                                            class="text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 px-2 py-1 rounded-lg transition-all duration-200">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <form action="{{ route('syncpenyediasikap') }}" method="post" class="inline">
                                            @csrf
                                            <input type="hidden" name="npwp_penyedia" value="{{ $item->npwp_penyedia }}">
                                            <button type="submit"
                                                class="text-orange-600 hover:text-orange-800 bg-orange-50 hover:bg-orange-100 px-2 py-1 rounded-lg transition-all duration-200"
                                                title="Sync data untuk NPWP {{ $item->npwp_penyedia }}">
                                                <i class="fas fa-sync text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="6" class="py-16 text-center">
                                    <div
                                        class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-exclamation-circle text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-700 mb-2">Belum ada data penyedia</h3>
                                    <p class="text-gray-500 text-sm">Silakan sinkronisasi data untuk memulai</p>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="noResultsRow" class="hidden">
                            <td colspan="6" class="py-16 text-center">
                                <div
                                    class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-search text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-base font-medium text-gray-700 mb-2">Tidak ada hasil ditemukan</h3>
                                <p class="text-gray-500 text-sm">Coba ubah kata kunci pencarian</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($penyedia->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 bg-white rounded-b-xl">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-700">
                            Menampilkan {{ $penyedia->firstItem() }} - {{ $penyedia->lastItem() }} dari
                            {{ $penyedia->total() }} hasil
                        </div>
                        <div>
                            {{ $penyedia->appends(['search' => request('search')])->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div id="detailModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-black/50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <div
                    class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b border-gray-100/60 p-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-building text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 tracking-tight">Detail Penyedia</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Informasi lengkap penyedia</p>
                            </div>
                        </div>
                        <button type="button" data-modal-hide="detailModal"
                            class="w-8 h-8 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-building mr-1 text-blue-500"></i>Nama Penyedia
                                </label>
                                <p id="detail-nama" class="text-sm text-gray-900 font-semibold"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-hashtag mr-1 text-blue-500"></i>Kode Penyedia
                                </label>
                                <p id="detail-kode" class="text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-id-card mr-1 text-indigo-500"></i>NPWP
                                </label>
                                <p id="detail-npwp" class="text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-industry mr-1 text-purple-500"></i>Bentuk Usaha
                                </label>
                                <p id="detail-bentuk" class="text-sm text-gray-900"></p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-phone mr-1 text-green-500"></i>Telepon
                                </label>
                                <p id="detail-telepon" class="text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-map-marker-alt mr-1 text-orange-500"></i>Alamat
                                </label>
                                <p id="detail-alamat" class="text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-tag mr-1 text-red-500"></i>Status OAP
                                </label>
                                <span id="detail-oap"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-100">
                    <button data-modal-hide="detailModal" type="button"
                        class="px-4 py-2 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg font-medium text-xs transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-times mr-1 text-xs"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="editOapModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-black/50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <div
                    class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b border-gray-100/60 p-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-edit text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 tracking-tight">Edit Status OAP</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Ubah status OAP penyedia</p>
                            </div>
                        </div>
                        <button type="button" data-modal-hide="editOapModal"
                            class="w-8 h-8 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <form id="editOapForm" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                            <i class="fas fa-building mr-1 text-blue-500"></i>Nama Penyedia
                        </label>
                        <p id="edit-nama" class="text-sm text-gray-900 font-semibold bg-gray-50 p-2 rounded"></p>
                    </div>
                    <div class="space-y-1">
                        <label for="oap_status" class="block text-xs font-semibold text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-red-500"></i>Status OAP <span class="text-red-500">*</span>
                        </label>
                        <select id="oap_status" name="oap"
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-xs">
                            <option value="">Belum Ditentukan</option>
                            <option value="1">OAP (Ya)</option>
                            <option value="0">Non OAP (Tidak)</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button type="button" data-modal-hide="editOapModal"
                            class="px-4 py-2 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg font-medium text-xs transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-times mr-1 text-xs"></i>
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-medium text-xs transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-1 text-xs"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const setupModalController = (modalId, handlers) => {
                const modalElement = document.getElementById(modalId);
                if (!modalElement) return;

                document.querySelectorAll(`[data-modal-toggle="${modalId}"]`).forEach(button => {
                    button.addEventListener('click', () => {
                        const itemData = button.dataset.item;
                        const actionUrl = button.dataset.action;

                        if (!itemData) {
                            console.error(
                                `Button for modal ${modalId} is missing data-item attribute.`
                            );
                            return;
                        }

                        try {
                            const item = JSON.parse(itemData);
                            if (handlers.onShow) {
                                handlers.onShow(modalElement, item, actionUrl);
                            }
                        } catch (error) {
                            console.error('Error parsing item data:', error);
                        }
                    });
                });
            };

            setupModalController('detailModal', {
                onShow: (modal, item) => {
                    document.getElementById('detail-nama').textContent = item.nama_penyedia || '-';
                    document.getElementById('detail-kode').textContent = item.kd_penyedia || '-';
                    document.getElementById('detail-npwp').textContent = item.npwp_penyedia || '-';
                    document.getElementById('detail-bentuk').textContent = item.bentuk_usaha || '-';
                    document.getElementById('detail-telepon').textContent = item.telepon || '-';

                    let alamat = '';
                    if (item.alamat) alamat += item.alamat;
                    if (item.kabupaten_kota) alamat += (alamat ? ', ' : '') + item.kabupaten_kota;
                    if (item.provinsi) alamat += (alamat ? ', ' : '') + item.provinsi;
                    document.getElementById('detail-alamat').textContent = alamat || '-';

                    const oapSpan = document.getElementById('detail-oap');
                    if (item.oap === 1) {
                        oapSpan.className =
                            'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                        oapSpan.innerHTML = '<i class="fas fa-check-circle mr-1"></i>OAP';
                    } else if (item.oap === 0) {
                        oapSpan.className =
                            'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                        oapSpan.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Non OAP';
                    } else {
                        oapSpan.className =
                            'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                        oapSpan.innerHTML =
                            '<i class="fas fa-question-circle mr-1"></i>Belum Ditentukan';
                    }
                }
            });

            setupModalController('editOapModal', {
                onShow: (modal, item, actionUrl) => {
                    document.getElementById('edit-nama').textContent = item.nama_penyedia || '-';
                    document.getElementById('oap_status').value = item.oap !== null ? item.oap
                        .toString() : '';

                    const form = document.getElementById('editOapForm');
                    form.action = actionUrl ||
                        `{{ route('editpenyedia', ['id' => encrypt($item->id ?? 0)]) }}`;
                }
            });
        });
    </script>
</x-app-layout>
