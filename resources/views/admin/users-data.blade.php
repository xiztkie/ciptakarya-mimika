<x-app-layout :title="$title" :subtitle="$subtitle ?? ''">
    <div
        class="bg-gradient-to-br from-sky-500 to-cyan-500 text-white py-6 md:py-8 rounded-b-2xl shadow-lg overflow-hidden relative">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full filter blur-lg"></div>
        <div class="absolute -bottom-12 -left-10 w-56 h-56 bg-white/10 rounded-full filter blur-lg"></div>
        <div class="absolute -bottom-4 -right-4 text-white/10 text-8xl transform rotate-12 hidden md:block">
            <i class="fas fa-users"></i>
        </div>

        <div class="container mx-auto px-4 sm:px-6 relative">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-center md:text-left z-10">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight"
                        style="text-shadow: 0 1px 3px rgba(0,0,0,0.2);">
                        Manajemen Pengguna
                    </h1>
                    <p class="text-sm sm:text-base text-sky-100 max-w-md mt-1">
                        Kelola, tambah, dan perbarui data pengguna sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-0 max-w-screen-2xl mx-auto">
        <div
            class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 rounded-t-xl shadow-2xl mt-4 overflow-hidden relative">
            <div class="absolute inset-0 bg-gradient-to-r from-white/5 to-transparent"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>

            <div class="relative p-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div class="text-white space-y-2">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold tracking-tight">Data Pengguna</h2>
                                <p class="text-blue-100 text-xs font-medium">
                                    Kelola dan pantau semua pengguna sistem</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-auto">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                            <button type="button" data-modal-target="add-modal" data-modal-toggle="add-modal"
                                class="h-9 px-4 bg-white/20 hover:bg-white/30 text-white rounded-lg shadow-lg font-semibold transition-all duration-300 hover:shadow-xl hover:scale-105 backdrop-blur-sm border border-white/20 flex items-center justify-center gap-2 min-w-[140px]">
                                <i class="fas fa-plus text-xs"></i>
                                <span class="text-xs">Tambah User</span>
                            </button>

                            <form action="{{ route('users') }}" method="GET" class="flex items-center gap-2 w-full"
                                id="search-form">
                                <div class="relative group flex-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i
                                            class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors text-xs"></i>
                                    </div>
                                    <input type="text" placeholder="Cari pengguna..." name="search"
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
                                        <a href="{{ route('users') }}" class="ml-1 hover:text-red-200">
                                            <i class="fas fa-times text-[8px]"></i>
                                        </a>
                                    </span>
                                    <a href="{{ route('users') }}"
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
            <div class="block lg:hidden p-6 space-y-4">
                @forelse ($users as $index => $item)
                    <div
                        class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center space-x-4 flex-1">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                        @if ($item->avatar)
                                            <img class="w-12 h-12 rounded-xl object-cover"
                                                src="{{ asset('storage/' . $item->avatar) }}" alt="{{ $item->name }}">
                                        @else
                                            <span
                                                class="text-white font-bold text-lg">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $item->name }}</h3>
                                    <p class="text-xs text-gray-500"><a>@</a>{{ $item->username }}</p>
                                    <p class="text-xs text-gray-600">{{ $item->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button data-modal-toggle="edit-modal{{ $item->id }}"
                                    data-modal-target="edit-modal{{ $item->id }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </button>
                                <button data-modal-toggle="pass-modal{{ $item->id }}"
                                    data-modal-target="pass-modal{{ $item->id }}"
                                    class="bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg">
                                    <i class="fas fa-key text-xs"></i>
                                </button>
                                @if ($item->role != 'Admin')
                                    <button data-modal-toggle="delete-modal{{ $item->id }}"
                                        data-modal-target="delete-modal{{ $item->id }}"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div class="space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-shield-alt mr-2 text-purple-500 text-xs"></i>
                                    <span class="font-medium">Role:</span>
                                </div>
                                @if ($item->role == 'Admin')
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                        <i class="fas fa-crown mr-1"></i>
                                        Admin
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fas fa-user mr-1"></i>
                                        User
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-toggle-on mr-2 text-emerald-500 text-xs"></i>
                                    <span class="font-medium">Status:</span>
                                </div>
                                @if ($item->status == 'Aktif')
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></div>
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Tidak ada data pengguna</h3>
                        <p class="text-gray-500 text-xs">Belum ada pengguna yang terdaftar atau sesuai pencarian</p>
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
                                    <i class="fas fa-user mr-1 text-xs"></i>
                                    Nama Pengguna
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-envelope mr-1 text-xs"></i>
                                    Email
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-shield-alt mr-1 text-xs"></i>
                                    Role
                                </div>
                            </th>
                            <th class="px-4 py-3 text-center border-b border-gray-200">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-toggle-on mr-1 text-xs"></i>
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
                            $startNumber = $users->firstItem();
                        @endphp
                        @forelse ($users as $index => $item)
                            <tr
                                class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 transition-all duration-200">
                                <td class="px-4 py-3 text-xs font-bold text-center text-gray-700">
                                    <div
                                        class="bg-sky-100 text-sky-800 rounded-full w-6 h-6 flex items-center justify-center mx-auto">
                                        {{ $startNumber++ }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                                                @if ($item->avatar)
                                                    <img class="w-10 h-10 rounded-lg object-cover"
                                                        src="{{ asset('storage/' . $item->avatar) }}"
                                                        alt="{{ $item->name }}">
                                                @else
                                                    <span
                                                        class="text-white font-bold text-sm">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate">{{ $item->name }}
                                            </p>
                                            <span
                                                class="text-xs text-gray-500 truncate"><a>@</a>{{ $item->username }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                        <span class="text-gray-700 font-medium">{{ $item->email }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-center">
                                    @if ($item->role == 'Admin')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                            <i class="fas fa-crown mr-1 text-[8px]"></i>
                                            Admin
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <i class="fas fa-user mr-1 text-[8px]"></i>
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-center">
                                    @if ($item->status == 'Aktif')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></div>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-red-100 text-red-800 border border-red-200">
                                            <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-1">
                                        <button data-modal-toggle="edit-modal{{ $item->id }}"
                                            data-modal-target="edit-modal{{ $item->id }}" title="Edit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg transform hover:scale-105">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </button>
                                        <button data-modal-toggle="pass-modal{{ $item->id }}"
                                            data-modal-target="pass-modal{{ $item->id }}" title="Ganti Password"
                                            class="bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg transform hover:scale-105">
                                            <i class="fas fa-key text-xs"></i>
                                        </button>
                                        @if ($item->role != 'Admin')
                                            <button data-modal-toggle="delete-modal{{ $item->id }}"
                                                data-modal-target="delete-modal{{ $item->id }}" title="Hapus"
                                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg transition-all duration-200 hover:shadow-lg transform hover:scale-105">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div
                                        class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-users text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Tidak ada data pengguna</h3>
                                    <p class="text-gray-500 text-xs">Belum ada pengguna yang terdaftar atau sesuai
                                        pencarian</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                    {{ $users->appends(['search' => request('search')])->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <div id="add-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 bg-black/50 backdrop-blur-sm max-h-screen">
        <div class="relative w-full max-w-3xl max-h-full mx-auto mt-8">
            <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100/50 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-b border-gray-100/60 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-user-plus text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 tracking-tight">Tambah User Baru</h3>
                                <p class="text-sm text-gray-500 mt-0.5">Buat akun pengguna baru untuk sistem</p>
                            </div>
                        </div>
                        <button type="button"
                            class="w-10 h-10 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-xl transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md"
                            data-modal-hide="add-modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form action="{{ route('adduser') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="p-8 space-y-8">
                        <div
                            class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 p-6 bg-gradient-to-br from-gray-50/50 to-blue-50/30 rounded-2xl border border-gray-100/60">
                            <div class="relative group">
                                <img id="avatar-preview"
                                    class="h-24 w-24 object-cover rounded-2xl shadow-lg border-4 border-white group-hover:shadow-xl transition-all duration-300"
                                    src="{{ asset('assets/images/user-profile.png') }}" alt="Avatar preview" />
                                <div
                                    class="absolute inset-0 bg-black/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <i class="fas fa-camera text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Foto Profil</h4>
                                <p class="text-sm text-gray-500 mb-4">Pilih foto profil untuk pengguna baru</p>
                                <label
                                    class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl border border-gray-200 cursor-pointer transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-upload mr-2 text-blue-500"></i>
                                    <span>Pilih Foto</span>
                                    <input type="file" name="avatar" id="avatar" accept="image/*"
                                        class="hidden" />
                                </label>
                                @error('avatar')
                                    <p class="mt-2 text-xs text-red-500 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-user text-blue-500 mr-2"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="Masukan nama lengkap..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                @error('name')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="username" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-at text-green-500 mr-2"></i>
                                    Username
                                </label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}"
                                    placeholder="Masukan username..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                @error('username')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-envelope text-purple-500 mr-2"></i>
                                    Email
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="Masukan alamat email..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                @error('email')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="contact" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-phone text-orange-500 mr-2"></i>
                                    Kontak (No. HP)
                                </label>
                                <input type="text" name="contact" id="contact" value="{{ old('contact') }}"
                                    placeholder="Masukan nomor kontak..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                @error('contact')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="password" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-lock text-red-500 mr-2"></i>
                                    Password
                                </label>
                                <input type="password" name="password" id="password"
                                    placeholder="Masukan password..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                @error('password')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation"
                                    class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-lock text-red-500 mr-2"></i>
                                    Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Konfirmasi password anda..."
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                            </div>

                            <div class="space-y-2">
                                <label for="role" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-shield-alt text-indigo-500 mr-2"></i>
                                    Role
                                </label>
                                <select id="role" name="role"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                                    <option value="" selected disabled>Pilih Role</option>
                                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="status" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-toggle-on text-emerald-500 mr-2"></i>
                                    Status
                                </label>
                                <select id="status" name="status"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50/30 border-t border-gray-100/60 px-8 py-6">
                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" data-modal-hide="add-modal"
                                class="px-6 py-3 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-medium text-sm transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($users as $item)
        <div id="edit-modal{{ $item->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 bg-black/50 backdrop-blur-sm max-h-screen">
            <div class="relative w-full max-w-3xl max-h-full mx-auto mt-8">
                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100/50 overflow-hidden">
                    <div
                        class="bg-gradient-to-r from-amber-50 via-orange-50 to-yellow-50 border-b border-gray-100/60 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user-edit text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 tracking-tight">Edit Pengguna</h3>
                                    <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi pengguna
                                        {{ $item->name }}</p>
                                </div>
                            </div>
                            <button type="button"
                                class="w-10 h-10 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-xl transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md"
                                data-modal-hide="edit-modal{{ $item->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('edituser', ['id' => encrypt($item->id)]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="p-8 space-y-8">
                            <div
                                class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 p-6 bg-gradient-to-br from-gray-50/50 to-amber-50/30 rounded-2xl border border-gray-100/60">
                                <div class="relative group">
                                    <img id="avatar-preview{{ $item->id }}"
                                        class="h-24 w-24 object-cover rounded-2xl shadow-lg border-4 border-white group-hover:shadow-xl transition-all duration-300"
                                        src="{{ $item->avatar ? asset('storage/' . $item->avatar) : asset('assets/images/user-profile.png') }}"
                                        alt="Current avatar" />
                                    <div
                                        class="absolute inset-0 bg-black/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <i class="fas fa-camera text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-1 text-center sm:text-left">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Foto Profil</h4>
                                    <p class="text-sm text-gray-500 mb-4">Ubah foto profil pengguna</p>
                                    <label
                                        class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl border border-gray-200 cursor-pointer transition-all duration-200 shadow-sm hover:shadow-md">
                                        <i class="fas fa-upload mr-2 text-amber-500"></i>
                                        <span>Ubah Foto</span>
                                        <input type="file" name="avatar" id="avatar{{ $item->id }}"
                                            accept="image/*" class="hidden" />
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="name{{ $item->id }}"
                                        class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-user text-blue-500 mr-2"></i>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" name="name" id="name{{ $item->id }}"
                                        value="{{ old('name', $item->name) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                </div>

                                <div class="space-y-2">
                                    <label for="username{{ $item->id }}"
                                        class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-at text-gray-400 mr-2"></i>
                                        Username
                                    </label>
                                    <input type="text" name="username" id="username{{ $item->id }}" disabled
                                        value="{{ old('username', $item->username) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 text-sm cursor-not-allowed" />
                                    <p class="text-xs text-gray-400">Username tidak dapat diubah</p>
                                </div>

                                <div class="space-y-2">
                                    <label for="email{{ $item->id }}"
                                        class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-envelope text-purple-500 mr-2"></i>
                                        Email
                                    </label>
                                    <input type="email" name="email" id="email{{ $item->id }}"
                                        value="{{ old('email', $item->email) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                </div>

                                <div class="space-y-2">
                                    <label for="contact{{ $item->id }}"
                                        class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-phone text-orange-500 mr-2"></i>
                                        Kontak (No. HP)
                                    </label>
                                    <input type="text" name="contact" id="contact{{ $item->id }}"
                                        value="{{ old('contact', $item->contact) }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm" />
                                </div>

                                <div class="space-y-2">
                                    <label for="role{{ $item->id }}"
                                        class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-shield-alt text-gray-400 mr-2"></i>
                                        Role
                                    </label>
                                    <select id="role{{ $item->id }}" name="role" disabled
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 text-sm cursor-not-allowed">
                                        <option value="Admin"
                                            {{ old('role', $item->role) == 'Admin' ? 'selected' : '' }}>
                                            Admin</option>
                                        <option value="User"
                                            {{ old('role', $item->role) == 'User' ? 'selected' : '' }}>User</option>
                                    </select>
                                    <input type="hidden" name="role" value="{{ old('role', $item->role) }}">
                                    <p class="text-xs text-gray-400">Role tidak dapat diubah</p>
                                </div>

                                <div class="space-y-2">
                                    <label for="status{{ $item->id }}"
                                        class="flex items-center text-sm font-semibold text-gray-700">
                                        <i class="fas fa-toggle-on text-emerald-500 mr-2"></i>
                                        Status
                                    </label>
                                    <select id="status{{ $item->id }}" name="status"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                                        <option value="Aktif"
                                            {{ old('status', $item->status) == 'Aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="Tidak Aktif"
                                            {{ old('status', $item->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                            Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-r from-gray-50 to-amber-50/30 border-t border-gray-100/60 px-8 py-6">
                            <div class="flex items-center justify-end space-x-4">
                                <button type="button" data-modal-hide="edit-modal{{ $item->id }}"
                                    class="px-6 py-3 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white rounded-xl font-medium text-sm transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="pass-modal{{ $item->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 bg-black/50 backdrop-blur-sm max-h-screen">
            <div class="relative w-full max-w-lg max-h-full mx-auto mt-16">
                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100/50 overflow-hidden">
                    <!-- Header -->
                    <div
                        class="bg-gradient-to-r from-emerald-50 via-teal-50 to-cyan-50 border-b border-gray-100/60 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-key text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 tracking-tight">Ganti Password</h3>
                                    <p class="text-sm text-gray-500 mt-0.5">Ubah password untuk {{ $item->name }}
                                    </p>
                                </div>
                            </div>
                            <button type="button"
                                class="w-10 h-10 bg-white/80 hover:bg-white text-gray-400 hover:text-gray-600 rounded-xl transition-all duration-200 flex items-center justify-center shadow-sm hover:shadow-md"
                                data-modal-hide="pass-modal{{ $item->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('updatepassword', ['id' => encrypt($item->id)]) }}" method="post">
                        @csrf
                        <div class="p-8 space-y-6">
                            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <i class="fas fa-info text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">Informasi</p>
                                        <p class="text-sm text-blue-600 mt-1">Anda akan mengganti password untuk
                                            pengguna <strong class="font-semibold">{{ $item->name }}</strong>.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="password" class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-lock text-emerald-500 mr-2"></i>
                                    Password Baru
                                </label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 text-sm"
                                    required>
                                @error('password')
                                    <p class="text-xs text-red-500 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirm"
                                    class="flex items-center text-sm font-semibold text-gray-700">
                                    <i class="fas fa-lock text-emerald-500 mr-2"></i>
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" name="password_confirm" id="password_confirm"
                                    placeholder="••••••••"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 text-sm"
                                    required>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div
                            class="bg-gradient-to-r from-gray-50 to-emerald-50/30 border-t border-gray-100/60 px-8 py-6">
                            <div class="flex items-center justify-end space-x-4">
                                <button type="button" data-modal-hide="pass-modal{{ $item->id }}"
                                    class="px-6 py-3 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium text-sm transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-key mr-2"></i>
                                    Simpan Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="delete-modal{{ $item->id }}" tabindex="-1"
            class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 bg-black/50 backdrop-blur-sm max-h-screen flex items-center justify-center">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100/50 overflow-hidden">
                    <div class="p-8 text-center">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-red-100 to-rose-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Penghapusan</h3>
                        <p class="text-gray-600 mb-6">
                            Apakah Anda yakin ingin menghapus pengguna <br>
                            <strong class="font-semibold text-gray-800">"{{ $item->name }}"</strong>?
                        </p>

                        <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6">
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-5 h-5 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-exclamation text-white text-xs"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-red-800">Peringatan!</p>
                                    <p class="text-sm text-red-600 mt-1">Tindakan ini tidak dapat dibatalkan dan akan
                                        menghapus semua data pengguna.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center space-x-4">
                            <button data-modal-hide="delete-modal{{ $item->id }}" type="button"
                                class="px-6 py-3 text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-times mr-2"></i>
                                Tidak, batalkan
                            </button>
                            <form action="{{ route('deleteuser', ['id' => encrypt($item->id)]) }}" method="POST"
                                class="inline-flex">
                                @csrf
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white rounded-xl font-medium text-sm transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Ya, saya yakin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            if (avatarInput && avatarPreview) {
                avatarInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => avatarPreview.src = e.target.result;
                        reader.readAsDataURL(file);
                    } else {
                        avatarPreview.src = "{{ asset('assets/images/user-profile.png') }}";
                    }
                });
            }

            @foreach ($users as $item)
                const avatarInput{{ $item->id }} = document.getElementById('avatar{{ $item->id }}');
                const avatarPreview{{ $item->id }} = document.getElementById(
                    'avatar-preview{{ $item->id }}');
                if (avatarInput{{ $item->id }} && avatarPreview{{ $item->id }}) {
                    avatarInput{{ $item->id }}.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => avatarPreview{{ $item->id }}.src = e.target.result;
                            reader.readAsDataURL(file);
                        }
                    });
                }
            @endforeach
        });
    </script>
</x-app-layout>
