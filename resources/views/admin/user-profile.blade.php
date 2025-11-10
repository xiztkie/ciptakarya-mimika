<x-app-layout :title="$title" :subtitle="$subtitle ?? ''" :active="$active">

    <div class="max-w-6xl mx-auto mt-20 px-3 md:px-4 text-[13px] md:text-[14px] leading-[1.45]">
        <div
            class="bg-white/90 dark:bg-gray-800/90 rounded-3xl shadow-xl overflow-hidden transition-all duration-300 border border-gray-100/70 dark:border-gray-700/70 ring-1 ring-gray-100/60 dark:ring-gray-700/60 backdrop-blur">
            <div class="md:flex">
                <div
                    class="md:w-1/3 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-900 p-8 md:p-9 text-center flex flex-col items-center relative">
                    <div
                        class="absolute top-0 right-0 w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-indigo-200 to-purple-200 dark:from-indigo-900 dark:to-purple-900 rounded-full opacity-20 -translate-y-12 md:-translate-y-16 translate-x-12 md:translate-x-16">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-20 h-20 md:w-24 md:h-24 bg-gradient-to-tr from-pink-200 to-yellow-200 dark:from-pink-900 dark:to-yellow-900 rounded-full opacity-20 translate-y-10 md:translate-y-12 -translate-x-10 md:-translate-x-12">
                    </div>

                    <form action="{{ route('updateavatar') }}" method="POST" enctype="multipart/form-data"
                        class="flex flex-col items-center w-full relative z-10" x-data="{ newAvatarUrl: null }">
                        @csrf
                        <div class="relative group mb-5">
                            <div
                                class="absolute -inset-1.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full opacity-70 blur group-hover:opacity-100 transition duration-500">
                            </div>
                            <img :src="newAvatarUrl ? newAvatarUrl :
                                '{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4f46e5&color=fff&size=192' }}'"
                                alt="Profile Picture"
                                class="relative w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4 border-white/90 dark:border-gray-700/90 shadow-2xl transition-transform duration-500 group-hover:scale-[1.03]">
                            <label for="avatar"
                                class="absolute bottom-1.5 right-1.5 w-9 h-9 md:w-10 md:h-10 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg ring-2 ring-white/80 dark:ring-gray-800/80 transform transition-all duration-300 hover:scale-110 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800">
                                <i class="fas fa-camera text-[10px] md:text-xs"></i>
                                <span class="sr-only">Ganti avatar</span>
                            </label>
                            <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*"
                                @change="newAvatarUrl = URL.createObjectURL($event.target.files[0])">
                        </div>

                        <div class="text-center mb-5">
                            <h1
                                class="text-lg md:text-[1.05rem] font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-1.5 tracking-tight">
                                {{ auth()->user()->name }}
                            </h1>
                            <div
                                class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 rounded-full ring-1 ring-indigo-200/60 dark:ring-indigo-700/60">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                <p class="text-indigo-700 dark:text-indigo-300 font-medium text-[11px]">
                                    {{ auth()->user()->role }}</p>
                            </div>
                        </div>

                        <div class="w-full space-y-2.5">
                            <button type="submit" x-show="newAvatarUrl" x-transition
                                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-2 rounded-lg hover:from-green-600 hover:to-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 font-medium text-[12px]">
                                <i class="fas fa-save text-[10px]"></i>
                                <span>Simpan Avatar</span>
                            </button>
                            <button type="button" onclick="openModal('editProfileModal')"
                                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-3 py-2 rounded-lg hover:from-indigo-600 hover:to-purple-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 font-medium text-[12px]">
                                <i class="fas fa-edit text-[10px]"></i>
                                <span>Edit Profile</span>
                            </button>
                            <button type="button" onclick="openModal('changePasswordModal')"
                                class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white px-3 py-2 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 font-medium text-[12px]">
                                <i class="fas fa-key text-[10px]"></i>
                                <span>Ubah Password</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="md:w-2/3 p-6 md:p-8">
                    <div class="border-b border-gray-200/70 dark:border-gray-700/70 pb-5 mb-5">
                        <div class="flex items-center gap-3 mb-2.5">
                            <div
                                class="w-9 h-9 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center ring-2 ring-indigo-200/50 dark:ring-indigo-800/50">
                                <i class="fas fa-user-circle text-white text-[15px]"></i>
                            </div>
                            <h2
                                class="text-[1.05rem] font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent tracking-tight">
                                Detail Profil</h2>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-[12.5px]">
                            Pengguna dengan username
                            <span
                                class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $user->username ?? 'user' }}</span>
                            dan email
                            <span
                                class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $user->email ?? 'user@gmail.com' }}</span>.
                            Aktif sejak <span
                                class="font-semibold">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>.
                        </p>
                    </div>

                    <div class="border-b border-gray-200/70 dark:border-gray-700/70 pb-5 mb-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-9 h-9 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center ring-2 ring-emerald-200/50 dark:ring-emerald-800/50">
                                <i class="fas fa-shield-alt text-white text-[15px]"></i>
                            </div>
                            <h2
                                class="text-[1.05rem] font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent tracking-tight">
                                Hak Akses</h2>
                        </div>
                        @php
                            $role = $user->role;
                            $permissions = [];
                            if ($role === 'Admin') {
                                $permissions = ['Dashboard', 'Peta Paket', 'Laporan', 'Master Data', 'Settings'];
                            } elseif ($role === 'User') {
                                $permissions = ['Dashboard'];
                            }
                        @endphp
                        <p class="text-gray-600 dark:text-gray-300 mb-3 text-[12.5px]">
                            Anda masuk sebagai
                            <span
                                class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">{{ $role }}</span>.
                            Berikut adalah akses menu yang diizinkan untuk Anda:
                        </p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            @forelse ($permissions as $menu)
                                <div
                                    class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 border border-indigo-200/70 dark:border-indigo-700/60 px-3 py-2 rounded-lg text-center group hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 hover:ring-1 hover:ring-indigo-300/60 dark:hover:ring-indigo-700/60">
                                    <span
                                        class="text-indigo-700 dark:text-indigo-300 font-medium text-xs group-hover:text-indigo-800 dark:group-hover:text-indigo-200">{{ $menu }}</span>
                                </div>
                            @empty
                                <div
                                    class="col-span-full bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600 px-4 py-6 rounded-lg text-center">
                                    <span class="text-gray-500 dark:text-gray-400 font-medium text-sm">Tidak ada
                                        permission.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="w-9 h-9 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center ring-2 ring-blue-200/50 dark:ring-blue-800/50">
                                <i class="fas fa-info-circle text-white text-[15px]"></i>
                            </div>
                            <h2
                                class="text-[1.05rem] font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent tracking-tight">
                                Informasi Pengguna</h2>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5">
                            <div class="space-y-2.5">
                                <div
                                    class="flex items-center gap-3 p-3 bg-gray-50/80 dark:bg-gray-800/50 rounded-lg hover:shadow-md transition-all duration-300 ring-1 ring-gray-200/70 dark:ring-gray-700/70">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0 text-white">
                                        <i class="fas fa-user text-[12px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Username</p>
                                        <p class="text-gray-800 dark:text-white font-semibold text-[13px]">
                                            {{ $user->username ?? 'username' }}</p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-3 p-3 bg-gray-50/80 dark:bg-gray-800/50 rounded-lg hover:shadow-md transition-all duration-300 ring-1 ring-gray-200/70 dark:ring-gray-700/70">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0 text-white">
                                        <i class="fas fa-envelope text-[12px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Email</p>
                                        <p class="text-gray-800 dark:text-white font-semibold text-[13px]">
                                            {{ $user->email ?? 'user@gmail.com' }}</p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-3 p-3 bg-gray-50/80 dark:bg-gray-800/50 rounded-lg hover:shadow-md transition-all duration-300 ring-1 ring-gray-200/70 dark:ring-gray-700/70">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center flex-shrink-0 text-white">
                                        <i class="fas fa-shield-alt text-[12px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Role</p>
                                        <p class="text-gray-800 dark:text-white font-semibold text-[13px]">
                                            {{ $user->role ?? 'Operator' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2.5">
                                <div
                                    class="flex items-center gap-3 p-3 bg-gray-50/80 dark:bg-gray-800/50 rounded-lg hover:shadow-md transition-all duration-300 ring-1 ring-gray-200/70 dark:ring-gray-700/70">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center flex-shrink-0 text-white">
                                        <i class="fas fa-phone text-[12px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Kontak</p>
                                        <p class="text-gray-800 dark:text-white font-semibold text-[13px]">
                                            {{ $user->contact ?? 'Belum diatur' }}</p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center gap-3 p-3 bg-gray-50/80 dark:bg-gray-800/50 rounded-lg hover:shadow-md transition-all duration-300 ring-1 ring-gray-200/70 dark:ring-gray-700/70">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0 text-white">
                                        <i class="fas fa-toggle-on text-[12px]"></i>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Status</p>
                                        <p class="text-gray-800 dark:text-white font-semibold text-[13px]">
                                            <span class="inline-flex items-center gap-1.5">
                                                <span class="w-2 h-2 rounded-full {{ $user->status === 'active' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                                {{ ucfirst($user->status ?? 'active') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editProfileModal"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm items-center justify-center hidden z-50 p-4">
        <div
            class="modal-panel bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-sm p-5 md:p-6 transform transition-all duration-300 opacity-0 scale-95 border border-gray-200/70 dark:border-gray-700/70 ring-1 ring-gray-100/70 dark:ring-gray-700/60">
            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-edit text-[12px]"></i>
                    </div>
                    <h3 class="text-[15px] font-bold text-gray-900 dark:text-white tracking-tight">Edit Profil</h3>
                </div>
                <button onclick="closeModal('editProfileModal')"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all duration-200">
                    <i class="fas fa-times text-[12px]"></i>
                </button>
            </div>
            <form action="{{ route('updateprofile', ['id' => encrypt($user->id)]) }}" method="POST"
                class="space-y-3.5">
                @csrf
                <div>
                    <label for="name"
                        class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama
                        Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-[13px]">
                    @error('name')
                        <p class="text-red-500 text-[11.5px] mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="email"
                        class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alamat
                        Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-[13px]">
                    @error('email')
                        <p class="text-red-500 text-[11.5px] mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="contact"
                        class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor
                        Kontak</label>
                    <input type="text" name="contact" id="contact"
                        value="{{ old('contact', $user->contact) }}" placeholder="Contoh: +62 812 3456 7890"
                        class="w-full px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-[13px]">
                    @error('contact')
                        <p class="text-red-500 text-[11.5px] mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="flex justify-end gap-2.5 pt-3">
                    <button type="button" onclick="closeModal('editProfileModal')"
                        class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium text-[12px]">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-3.5 py-2 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 text-white hover:from-indigo-600 hover:to-purple-600 transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-[12px]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="changePasswordModal"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm items-center justify-center hidden z-50 p-4">
        <div
            class="modal-panel bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-sm p-5 md:p-6 transform transition-all duration-300 opacity-0 scale-95 border border-gray-200/70 dark:border-gray-700/70 ring-1 ring-gray-100/70 dark:ring-gray-700/60">
            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-gray-600 to-gray-700 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-key text-[12px]"></i>
                    </div>
                    <h3 class="text-[15px] font-bold text-gray-900 dark:text-white tracking-tight">Ubah Password</h3>
                </div>
                <button onclick="closeModal('changePasswordModal')"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all duration-200">
                    <i class="fas fa-times text-[12px]"></i>
                </button>
            </div>
            <form action="{{ route('changepassword', ['id' => encrypt($user->id)]) }}" method="POST"
                class="space-y-3.5">
                @csrf
                <div>
                    <label for="current_password"
                        class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password Saat
                        Ini</label>
                    <input type="password" name="current_password" id="current_password" required
                        placeholder="Masukkan password saat ini"
                        class="w-full px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-[13px]">
                    @error('current_password')
                        <p class="text-red-500 text-[11.5px] mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="new_password"
                        class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password
                        Baru</label>
                    <input type="password" name="new_password" id="new_password" required
                        placeholder="Masukkan password baru"
                        class="w-full px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-[13px]">
                    @error('new_password')
                        <p class="text-red-500 text-[11.5px] mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="new_password_confirmation"
                        class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi
                        Password
                        Baru</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                        placeholder="Ulangi password baru"
                        class="w-full px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-[13px]">
                </div>
                <div class="flex justify-end gap-2.5 pt-3">
                    <button type="button" onclick="closeModal('changePasswordModal')"
                        class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium text-[12px]">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-3.5 py-2 rounded-lg bg-gradient-to-r from-gray-600 to-gray-700 text-white hover:from-gray-700 hover:to-gray-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-[12px]">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            const overlay = document.getElementById(id);
            const panel = overlay.querySelector('.modal-panel');

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            requestAnimationFrame(() => {
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            });

            if (!overlay._backdropBound) {
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) closeModal(id);
                });
                overlay._backdropBound = true;
            }

            const escHandler = (e) => {
                if (e.key === 'Escape') closeModal(id);
            };
            overlay._escHandler = escHandler;
            document.addEventListener('keydown', escHandler);
        }

        function closeModal(id) {
            const overlay = document.getElementById(id);
            const panel = overlay.querySelector('.modal-panel');

            panel.classList.remove('opacity-100', 'scale-100');
            panel.classList.add('opacity-0', 'scale-95');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');

                if (overlay._escHandler) {
                    document.removeEventListener('keydown', overlay._escHandler);
                    delete overlay._escHandler;
                }
            }, 300);
        }
    </script>

    @push('styles')
        <style>
            :root {
                --card-shadow: 0 8px 28px rgba(31, 38, 135, 0.08);
                --card-shadow-hover: 0 10px 35px rgba(31, 38, 135, 0.12);
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes modalIn {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.45s ease-out forwards;
            }

            .animate-modal-in {
                animation: modalIn 0.28s ease-out forwards;
            }

            .animate-pulse {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            /* Subtle hover for main card */
            .hover-card:hover {
                box-shadow: var(--card-shadow-hover);
            }
        </style>
    @endpush

</x-app-layout>
