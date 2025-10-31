<x-app-layout :title="$title" :subtitle="$subtitle ?? ''">
    {{-- Header Section --}}
    <div class="bg-gradient-to-br from-sky-500 to-cyan-500 text-white py-8 md:py-12 mb-8 rounded-b-2xl shadow-xl overflow-hidden relative">
        <div class="absolute -top-12 -right-12 w-56 h-56 bg-white/10 rounded-full filter blur-xl"></div>
        <div class="absolute -bottom-16 -left-12 w-64 h-64 bg-white/10 rounded-full filter blur-xl"></div>
        <div class="absolute -bottom-8 -right-8 text-white/10 text-9xl transform rotate-12 hidden md:block">
            <i class="fas fa-users text-9xl"></i>
        </div>

        <div class="container mx-auto px-4 sm:px-6 relative">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-center md:text-left mb-6 md:mb-0 z-10">
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-2" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        Manajemen Pengguna
                    </h1>
                    <p class="text-base sm:text-lg text-sky-100 max-w-lg">
                        Kelola, tambah, dan perbarui data pengguna sistem dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-0 w-full">
        {{-- Table Header --}}
        <div class="bg-white overflow-hidden shadow-md rounded-t-lg px-6 py-3 border-b border-gray-200">
            <h2 class="text-lg text-gray-800 font-semibold">
                Data Pengguna
            </h2>
        </div>

        <div class="bg-white shadow-xl rounded-b-lg p-6 space-y-6">
            {{-- Actions: Add Button & Search --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="w-full md:w-auto">
                    <button type="button" data-modal-target="add-modal" data-modal-toggle="add-modal"
                        class="w-full md:w-auto text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-lg font-semibold rounded-lg text-sm px-5 py-2.5 flex items-center justify-center transition-all duration-300">
                        <i class="fas fa-plus mr-2"></i> Tambah Pengguna
                    </button>
                </div>

                <form action="{{ route('users') }}" method="GET" class="w-full md:w-auto flex items-center" id="search-form">
                    <input type="text" placeholder="Cari pengguna..." name="search" value="{{ request('search') }}"
                        class="w-full md:w-80 h-10 border-gray-300 rounded-l-md px-3 text-sm focus:ring-sky-500 focus:border-sky-500 transition">
                    <button type="submit"
                        class="bg-sky-500 hover:bg-sky-600 text-white rounded-r-md px-4 h-10 font-medium transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            {{-- Users Table --}}
            <div class="overflow-x-auto border border-gray-200 shadow-sm rounded-lg">
                <table class="min-w-full bg-white divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-gray-600 uppercase text-xs font-semibold tracking-wider">
                            <th class="px-6 py-3 text-center w-16">No</th>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-center">Role</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $startNumber = $users->firstItem();
                        @endphp
                        @forelse ($users as $index => $item)
                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-sky-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-center text-gray-700">{{ $startNumber++ }}</td>
                                <td class="px-6 py-3 text-sm text-gray-800 font-medium">{{ $item->name }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->email }}</td>
                                <td class="px-6 py-3 text-center">
                                    <span class="px-3 py-1 text-xs font-semibold text-white rounded-full {{ $item->role == 'Administrator' ? 'bg-blue-600' : 'bg-green-600' }}">
                                        {{ $item->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    @if ($item->status == 'Aktif')
                                        <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-center gap-3">
                                        <button data-modal-toggle="edit-modal{{ $item->id }}" data-modal-target="edit-modal{{ $item->id }}" title="Edit"
                                            class="text-blue-500 hover:text-blue-700 transition duration-150">
                                            <i class="fas fa-pencil-alt fa-fw"></i>
                                        </button>
                                        <button data-modal-toggle="pass-modal{{ $item->id }}" data-modal-target="pass-modal{{ $item->id }}" title="Ganti Password"
                                            class="text-yellow-500 hover:text-yellow-700 transition duration-150">
                                            <i class="fas fa-key fa-fw"></i>
                                        </button>
                                        @if ($item->role != 'Administrator')
                                            <button data-modal-toggle="delete-modal{{ $item->id }}" data-modal-target="delete-modal{{ $item->id }}" title="Hapus"
                                                class="text-red-500 hover:text-red-700 transition duration-150">
                                                <i class="fas fa-trash-alt fa-fw"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-gray-500">
                                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                    <p>Data tidak ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="px-2 mt-4">
                {{ $users->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div id="add-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-xl shadow-sm">
                <div class="flex items-center justify-between p-4 border-b rounded-t-xl bg-gray-50">
                    <h3 class="text-xl font-semibold text-gray-800">
                        Tambah User Baru
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-modal" aria-label="Close modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup Modal</span>
                    </button>
                </div>
                <form action="{{ route('adduser') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                <img id="avatar-preview" class="h-24 w-24 object-cover rounded-full shadow-md" src="{{ asset('assets/images/user-profile.png') }}" alt="Avatar preview" />
                            </div>
                            <label class="block">
                                <span class="sr-only">Pilih foto profil</span>
                                <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                                @error('avatar')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukan nama lengkap..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="username" class="block mb-1 text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="Masukan username..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                @error('username')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukan alamat email..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="kontak" class="block mb-1 text-sm font-medium text-gray-700">Kontak (No. HP)</label>
                                <input type="text" name="kontak" id="kontak" value="{{ old('kontak') }}" placeholder="Masukan nomor kontak..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                @error('kontak')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password" placeholder="Masukan password..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password anda..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                            </div>
                            <div>
                                <label for="role" class="block mb-1 text-sm font-medium text-gray-700">Role</label>
                                <select id="role" name="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="" selected disabled>Pilih Role</option>
                                    <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                    <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                                @error('status')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-4 space-x-3 border-t border-gray-200 rounded-b bg-gray-50">
                        <button type="button" data-modal-hide="add-modal" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">Batal</button>
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($users as $item)
        {{-- Edit Modal --}}
        <div id="edit-modal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-xl shadow-sm">
                    <div class="flex items-center justify-between p-4 border-b rounded-t-xl bg-gray-50">
                        <h3 class="text-xl font-semibold text-gray-800">Edit Pengguna</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-modal{{ $item->id }}" aria-label="Close modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg>
                            <span class="sr-only">Tutup Modal</span>
                        </button>
                    </div>
                    <form action="{{ route('edituser', ['id' => encrypt($item->id)]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="p-6 space-y-6">
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    <img id="avatar-preview{{ $item->id }}" class="h-24 w-24 object-cover rounded-full shadow-md" src="{{ $item->avatar ? asset('storage/' . $item->avatar) : asset('assets/images/user-profile.png') }}" alt="Current avatar" />
                                </div>
                                <label class="block">
                                    <span class="sr-only">Pilih foto profil</span>
                                    <input type="file" name="avatar" id="avatar{{ $item->id }}" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                                </label>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name{{ $item->id }}" class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="name" id="name{{ $item->id }}" value="{{ old('name', $item->name) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label for="username{{ $item->id }}" class="block mb-1 text-sm font-medium text-gray-700">Username</label>
                                    <input type="text" name="username" id="username{{ $item->id }}" disabled value="{{ old('username', $item->username) }}" class="block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" />
                                </div>
                                <div>
                                    <label for="email{{ $item->id }}" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email{{ $item->id }}" value="{{ old('email', $item->email) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label for="kontak{{ $item->id }}" class="block mb-1 text-sm font-medium text-gray-700">Kontak (No. HP)</label>
                                    <input type="text" name="kontak" id="kontak{{ $item->id }}" value="{{ old('kontak', $item->kontak) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label for="role{{ $item->id }}" class="block mb-1 text-sm font-medium text-gray-700">Role</label>
                                    <select id="role{{ $item->id }}" name="role" disabled class="block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm">
                                        <option value="Administrator" {{ old('role', $item->role) == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                        <option value="User" {{ old('role', $item->role) == 'User' ? 'selected' : '' }}>User</option>
                                    </select>
                                    <input type="hidden" name="role" value="{{ old('role', $item->role) }}">
                                </div>
                                <div>
                                    <label for="status{{ $item->id }}" class="block mb-1 text-sm font-medium text-gray-700">Status</label>
                                    <select id="status{{ $item->id }}" name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 smtext-sm">
                                        <option value="Aktif" {{ old('status', $item->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status', $item->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end p-4 space-x-3 border-t border-gray-200 rounded-b bg-gray-50">
                             <button type="button" data-modal-hide="edit-modal{{ $item->id }}" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">Batal</button>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Change Password Modal --}}
        <div id="pass-modal{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-xl shadow-sm">
                    <div class="flex items-center justify-between p-4 border-b rounded-t-xl bg-gray-50">
                        <h3 class="text-xl font-semibold text-gray-800">Ganti Password</h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="pass-modal{{ $item->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg>
                            <span class="sr-only">Tutup Modal</span>
                        </button>
                    </div>
                    <form action="{{ route('changepass', ['id' => encrypt($item->id)]) }}" method="post">
                        @csrf
                        <div class="p-6 space-y-4">
                            <p class="text-sm text-gray-600">Anda akan mengganti password untuk pengguna <strong class="font-semibold text-gray-800">{{ $item->name }}</strong>.</p>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password_confirm" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirm" id="password_confirm" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                        </div>
                        <div class="flex items-center justify-end p-4 space-x-3 border-t border-gray-200 rounded-b bg-gray-50">
                            <button type="button" data-modal-hide="pass-modal{{ $item->id }}" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900">Batal</button>
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div id="delete-modal{{ $item->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50 flex items-center justify-center">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-xl">
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-red-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-600">
                            Apakah Anda yakin ingin menghapus pengguna <br> "<strong class="font-semibold text-gray-800">{{ $item->name }}</strong>"?
                        </h3>
                        <form action="{{ route('deleteuser', ['id' => encrypt($item->id)]) }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm items-center px-5 py-2.5 text-center mr-2">
                                Ya, saya yakin
                            </button>
                        </form>
                        <button data-modal-hide="delete-modal{{ $item->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                            Tidak, batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script for Add Modal Avatar Preview
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

            // Script for Edit Modal Avatar Previews
            @foreach ($users as $item)
                const avatarInput{{ $item->id }} = document.getElementById('avatar{{ $item->id }}');
                const avatarPreview{{ $item->id }} = document.getElementById('avatar-preview{{ $item->id }}');
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
