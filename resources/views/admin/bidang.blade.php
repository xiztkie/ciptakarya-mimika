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
                                <i class="fas fa-briefcase text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold tracking-tight">{{ $title }}</h2>
                                <p class="text-blue-100 text-xs font-medium">
                                    {{ $subtitle ?? 'Kelola data bidang dengan mudah dan efisien' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-auto">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                            <button type="button" data-modal-target="addBidangModal" data-modal-toggle="addBidangModal"
                                class="h-9 px-4 bg-white/20 hover:bg-white/30 text-white rounded-lg shadow-lg font-semibold transition-all duration-300 hover:shadow-xl hover:scale-105 backdrop-blur-sm border border-white/20 flex items-center justify-center gap-2 min-w-[160px]">
                                <i class="fas fa-plus text-xs"></i>
                                <span class="text-xs">Tambah Bidang</span>
                            </button>

                            <form action="{{ route('bidang') }}" method="GET" class="flex items-center gap-2 w-full"
                                id="search-form">
                                <div class="relative group flex-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i
                                            class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors text-xs"></i>
                                    </div>
                                    <input type="text" placeholder="Cari nama bidang..." name="search"
                                        value="{{ request('search') }}"
                                        class="w-full h-9 pl-9 pr-3 bg-white/95 backdrop-blur-sm border-0 rounded-lg shadow-lg text-xs placeholder-gray-500 focus:ring-2 focus:ring-white/50 focus:bg-white transition-all duration-300 font-medium">
                                </div>

                                <button type="submit"
                                    class="h-9 px-4 bg-white/20 hover:bg-white/30 text-white rounded-lg shadow-lg font-semibold transition-all duration-300 hover:shadow-xl hover:scale-105 backdrop-blur-sm border border-white/20 flex items-center justify-center gap-2 min-w-[80px] flex-shrink-0">
                                    <i class="fas fa-search text-xs"></i>
                                    <span class="hidden sm:inline text-xs">Cari</span>
                                </button>
                            </form>
                        </div>

                        @if (request('search'))
                            <div class="w-full lg:w-auto mt-3 lg:mt-3">
                                <div class="flex flex-wrap items-center gap-1">
                                    <span class="text-blue-100 text-[10px] font-medium">Filter aktif:</span>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 bg-white/20 text-white text-[10px] rounded-full backdrop-blur-sm">
                                        <i class="fas fa-search text-[8px]"></i>
                                        "{{ request('search') }}"
                                        <a href="{{ route('bidang') }}" class="ml-1 hover:text-red-200">
                                            <i class="fas fa-times text-[8px]"></i>
                                        </a>
                                    </span>
                                    <a href="{{ route('bidang') }}"
                                        class="text-blue-100 hover:text-white text-[10px] underline font-medium transition-colors">
                                        Hapus filter
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-2xl rounded-b-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-100">
                        <tr class="text-gray-700 uppercase text-xs font-bold tracking-wider">
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-hashtag mr-1 text-xs"></i>
                                    No
                                </div>
                            </th>
                            <th class="px-4 py-3 text-left border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fas fa-briefcase mr-2 text-xs"></i>
                                    Nama Bidang
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
                    <tbody class="divide-y divide-gray-100" id="bidangTableBody">
                        @forelse ($bidang as $index => $item)
                            <tr data-bidang="{{ strtolower($item->nama_bidang) }}"
                                class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 transition-all duration-200">
                                <td class="px-4 py-3 text-xs font-bold text-center text-gray-700">
                                    <div
                                        class="bg-sky-100 text-sky-800 rounded-full w-6 h-6 flex items-center justify-center mx-auto">
                                        {{ $loop->iteration }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-left">
                                    <div class="font-bold text-gray-800">{{ $item->nama_bidang }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <button data-modal-target="editBidangModal" data-modal-toggle="editBidangModal"
                                            data-action="{{ route('editbidang', ['id' => encrypt($item->id)]) }}"
                                            data-nama="{{ $item->nama_bidang }}" title="Edit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg transform hover:scale-105">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </button>
                                        <button data-modal-target="deleteBidangModal"
                                            data-modal-toggle="deleteBidangModal"
                                            data-action="{{ route('deletebidang', ['id' => encrypt($item->id)]) }}"
                                            data-nama="{{ $item->nama_bidang }}" title="Hapus"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg transform hover:scale-105">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="3" class="py-16 text-center">
                                    <div
                                        class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-exclamation-circle text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Belum ada data bidang</h3>
                                    <p class="text-gray-500 text-xs">Silakan tambah data bidang baru</p>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="noResultsRow" class="hidden">
                            <td colspan="3" class="py-16 text-center">
                                <div
                                    class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-search text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Tidak ada hasil ditemukan</h3>
                                <p class="text-gray-500 text-xs">Coba ubah kata kunci pencarian</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
             <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                {{ $bidang->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <div id="addBidangModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <div
                    class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b border-gray-100/60 p-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-plus text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 tracking-tight">Tambah Bidang Baru</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Masukkan informasi bidang baru</p>
                            </div>
                        </div>
                        <button type="button" data-modal-hide="addBidangModal"
                            class="w-8 h-8 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('addbidang') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label for="nama_bidang" class="flex items-center text-xs font-semibold text-gray-700">
                            <i class="fas fa-briefcase text-blue-500 mr-1 text-xs"></i>
                            Nama Bidang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_bidang" id="nama_bidang" required
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-xs"
                            placeholder="Masukkan nama bidang" />
                    </div>
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button type="button" data-modal-hide="addBidangModal"
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

    <div id="editBidangModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <div
                    class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b border-gray-100/60 p-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-pencil-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 tracking-tight">Edit Bidang</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Ubah informasi bidang</p>
                            </div>
                        </div>
                        <button type="button" data-modal-hide="editBidangModal"
                            class="w-8 h-8 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <form id="editBidangForm" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label for="edit_nama_bidang" class="flex items-center text-xs font-semibold text-gray-700">
                            <i class="fas fa-briefcase text-blue-500 mr-1 text-xs"></i>
                            Nama Bidang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_bidang" id="edit_nama_bidang" required
                            class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-xs"
                            placeholder="Masukkan nama bidang" />
                    </div>
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button type="button" data-modal-hide="editBidangModal"
                            class="px-4 py-2 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg font-medium text-xs transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-times mr-1 text-xs"></i>
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-medium text-xs transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-1 text-xs"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteBidangModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <div
                    class="bg-gradient-to-r from-red-50 via-red-50 to-red-100 border-b border-gray-100/60 p-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-lg">
                                <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 tracking-tight">Konfirmasi Hapus</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                            </div>
                        </div>
                        <button type="button" data-modal-hide="deleteBidangModal"
                            class="w-8 h-8 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-lg transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <i class="fas fa-trash-alt text-4xl text-red-500 mb-3"></i>
                        <h4 class="text-sm font-semibold text-gray-800 mb-2">Apakah Anda yakin?</h4>
                        <p class="text-xs text-gray-600">Data bidang <span id="deleteBidangName"
                                class="font-semibold"></span> akan dihapus secara permanen.</p>
                    </div>
                    <div class="flex items-center justify-center space-x-3 pt-6 mt-4 border-t border-gray-100">
                        <button type="button" data-modal-hide="deleteBidangModal"
                            class="px-4 py-2 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-lg font-medium text-xs transition-all duration-200 shadow-sm hover:shadow-md flex-1 text-center">
                            <i class="fas fa-times mr-1 text-xs"></i>
                            Batal
                        </button>
                        <form id="deleteBidangForm" method="POST" class="inline flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg font-medium text-xs transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-trash mr-1 text-xs"></i>
                                Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
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
                        const actionUrl = button.dataset.action;
                        const nama = button.dataset.nama;

                        if (!actionUrl) {
                            console.error(
                                `Button for modal ${modalId} is missing data-action attribute.`
                            );
                            return;
                        }

                        if (handlers.onShow) {
                            handlers.onShow(modalElement, actionUrl, nama);
                        }
                    });
                });
            };
            setupModalController('editBidangModal', {
                onShow: (modal, actionUrl, nama) => {
                    const form = modal.querySelector('#editBidangForm');
                    const inputNama = modal.querySelector('#edit_nama_bidang');

                    if (form && inputNama) {
                        form.action = actionUrl;
                        inputNama.value = nama;
                    }
                }
            });
            setupModalController('deleteBidangModal', {
                onShow: (modal, actionUrl, nama) => {
                    const form = modal.querySelector('#deleteBidangForm');
                    const textNama = modal.querySelector('#deleteBidangName');

                    if (form && textNama) {
                        form.action = actionUrl;
                        textNama.textContent = nama;
                    }
                }
            });
        });
    </script>

</x-app-layout>
