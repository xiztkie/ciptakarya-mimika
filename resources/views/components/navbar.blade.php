<nav
    class="w-full fixed top-0 left-0 bg-gradient-to-r from-yellow-400 via-yellow-100 to-white border-b border-yellow-200 shadow-lg z-50">
    <div class="mx-auto flex items-center justify-between px-4 md:px-8 h-16">
        <div class="flex items-center space-x-4 md:space-x-8">
            <a href="/" class="flex items-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="logo"
                    class="h-12 w-12 object-contain rounded-xl">
            </a>
            <div class="hidden md:flex items-center space-x-2 text-sm font-semibold">
                <a href="{{ route('dashboard') }}"
                    class="px-3 py-2 rounded transition text-gray-700 hover:text-gray-900 hover:bg-yellow-200/50 backdrop-blur-sm">Dashboards</a>
                <div class="relative group">
                    <button
                        class="flex items-center px-3 py-2 rounded transition text-gray-700 hover:text-gray-900 hover:bg-yellow-200/50 backdrop-blur-sm focus:outline-none">
                        Master Data
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.585l3.71-3.354a.75.75 0 1 1 1.02 1.1l-4.22 3.818a.75.75 0 0 1-1.02 0l-4.22-3.818a.75.75 0 0 1 .02-1.06z" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 mt-2 w-44 bg-white/95 backdrop-blur-md border border-yellow-200 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 pointer-events-none group-hover:pointer-events-auto group-focus-within:pointer-events-auto transition z-50">
                        <ul class="py-2 text-sm text-gray-700">
                            <li><a href="" class="block px-4 py-2 hover:bg-yellow-100/70">Data Paket</a></li>
                            <li><a href="" class="block px-4 py-2 hover:bg-yellow-100/70">Data Kontrak</a></li>
                        </ul>
                    </div>
                </div>
                <div class="relative group">
                    <button
                        class="flex items-center px-3 py-2 rounded transition text-gray-700 hover:text-gray-900 hover:bg-yellow-200/50 backdrop-blur-sm focus:outline-none">
                        Settings
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.585l3.71-3.354a.75.75 0 1 1 1.02 1.1l-4.22 3.818a.75.75 0 0 1-1.02 0l-4.22-3.818a.75.75 0 0 1 .02-1.06z" />
                        </svg>
                    </button>
                    <div
                        class="absolute left-0 mt-2 w-44 bg-white/95 backdrop-blur-md border border-yellow-200 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 pointer-events-none group-hover:pointer-events-auto group-focus-within:pointer-events-auto transition z-50">
                        <ul class="py-2 text-sm text-gray-700">
                            <li><a href="{{ route('sync-data') }}" class="block px-4 py-2 hover:bg-yellow-100/70">Sync
                                    Data</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-yellow-100/70">Users</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-yellow-100/70">App</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button"
                class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-yellow-100 shadow transition hover:bg-yellow-200 focus:outline-none overflow-hidden group">
                <svg id="hamburger-icon" class="absolute transition-all duration-300 w-7 h-7 text-yellow-500"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path id="top" stroke-linecap="round" stroke-linejoin="round" d="M4 7h16"
                        class="transition-all duration-300" />
                    <path id="middle" stroke-linecap="round" stroke-linejoin="round" d="M4 12h16"
                        class="transition-all duration-300" />
                    <path id="bottom" stroke-linecap="round" stroke-linejoin="round" d="M4 17h16"
                        class="transition-all duration-300" />
                </svg>
            </button>
        </div>
        <div class="relative ml-3 hidden md:block">
            @php($avatar = auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : null)
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" type="button"
                class="flex items-center justify-center w-12 h-12 rounded-full bg-white/60 backdrop-blur-md shadow-lg ring-1 ring-yellow-300 hover:bg-white/80 cursor-pointer focus:outline-none transition">
                @if ($avatar)
                    <img src="{{ $avatar }}" alt="User avatar" class="w-12 h-12 rounded-full object-cover">
                @else
                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-5.33 0-8 2.667-8 4v2h16v-2c0-1.333-2.67-4-8-4z" />
                    </svg>
                @endif
            </button>
            <div id="dropdownNavbar"
                class="absolute right-0 mt-2 z-50 hidden w-72 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl ring-1 ring-yellow-200 overflow-hidden">
                <div class="px-5 py-4 flex items-center gap-3 bg-gradient-to-r from-yellow-100/80 to-yellow-50/80">
                    <div class="shrink-0">
                        @if ($avatar)
                            <img src="{{ $avatar }}" class="w-12 h-12 rounded-full object-cover" alt="Avatar">
                        @else
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-5.33 0-8 2.667-8 4v2h16v-2c0-1.333-2.67-4-8-4z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 truncate">
                            {{ auth()->user()->name ?? auth()->user()->username }}
                        </p>
                        <p class="text-xs text-gray-600 truncate">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="" class="flex items-center px-5 py-2.5 hover:bg-yellow-100/70 transition">
                            <i class="fas fa-user w-5 mr-3 text-gray-500"></i>
                            Edit profile
                        </a>
                    </li>
                    <li>
                        <button type="button" data-modal-target="ubahPasswordModal"
                            data-modal-toggle="ubahPasswordModal"
                            class="flex items-center w-full px-5 py-2.5 hover:bg-yellow-100/70 transition text-left">
                            <i class="fas fa-key w-5 mr-3 text-gray-500"></i>
                            Ubah Password
                        </button>
                    </li>
                </ul>
                <div class="border-t border-gray-200/50">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-5 py-3 text-sm text-red-600 hover:bg-red-50/70 transition">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="mobile-menu"
        class="md:hidden fixed top-0 left-0 w-full h-full bg-white/90 backdrop-blur-xl shadow-2xl z-50 transform -translate-y-full transition-transform duration-500 rounded-b-2xl px-6 pt-7 pb-8 overflow-hidden">
        <img src="{{ asset('assets/images/logo.png') }}" alt="background logo"
            class="absolute bottom-4 right-4 w-48 h-48 object-contain opacity-10 -z-10">
        <button id="mobile-menu-close" type="button"
            class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center rounded-full bg-yellow-100 hover:bg-yellow-200 text-yellow-600 shadow focus:outline-none z-60">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="flex items-center mb-6 space-x-4">
            @if ($avatar)
                <img src="{{ $avatar }}"
                    class="h-12 w-12 rounded-full object-cover border-2 border-yellow-300 shadow" alt="Avatar">
            @else
                <div
                    class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-5.33 0-8 2.667-8 4v2h16v-2c0-1.333-2.67-4-8-4z" />
                    </svg>
                </div>
            @endif
            <span
                class="font-semibold text-lg text-yellow-800">{{ auth()->user()->name ?? auth()->user()->username }}</span>
        </div>
        <a href="{{ route('dashboard') }}"
            class="block px-4 py-3 rounded-xl font-semibold mb-2 transition {{ request()->routeIs('dashboard') ? 'bg-yellow-200 text-yellow-800' : 'text-gray-700 hover:bg-yellow-200' }}">Dashboards</a>
        <div class="mt-4">
            <span class="block px-3 py-2 text-gray-400 font-semibold">Master Data</span>
            <a href=""
                class="block px-5 py-2 rounded-xl transition {{ request()->routeIs('paket.*') ? 'bg-yellow-100 text-yellow-800 font-semibold' : 'text-gray-700 hover:text-yellow-700 hover:bg-yellow-100' }}">Data
                Paket</a>
            <a href=""
                class="block px-5 py-2 rounded-xl transition {{ request()->routeIs('kontrak.*') ? 'bg-yellow-100 text-yellow-800 font-semibold' : 'text-gray-700 hover:text-yellow-700 hover:bg-yellow-100' }}">Data
                Kontrak</a>
        </div>
        <div class="mt-4">
            <span class="block px-3 py-2 text-gray-400 font-semibold">Settings</span>
            <a href="{{ route('sync-data') }}"
                class="block px-5 py-2 rounded-xl transition {{ request()->routeIs('sync-data') ? 'bg-yellow-100 text-yellow-800 font-semibold' : 'text-gray-700 hover:text-yellow-700 hover:bg-yellow-100' }}">Sync
                Data</a>
            <a href="#"
                class="block px-5 py-2 rounded-xl transition {{ request()->routeIs('users.*') ? 'bg-yellow-100 text-yellow-800 font-semibold' : 'text-gray-700 hover:text-yellow-700 hover:bg-yellow-100' }}">Users</a>
            <a href="#"
                class="block px-5 py-2 rounded-xl transition {{ request()->routeIs('app.*') ? 'bg-yellow-100 text-yellow-800 font-semibold' : 'text-gray-700 hover:text-yellow-700 hover:bg-yellow-100' }}">App
                Settings</a>
        </div>
        <div class="mt-8 flex flex-col gap-2">
            <a href=""
                class="flex items-center px-4 py-2 rounded-xl transition text-gray-700 hover:bg-yellow-200 {{ request()->routeIs('profile.edit') ? 'bg-yellow-200' : '' }}">
                <i class="fas fa-user mr-3 text-gray-500"></i>Edit profile
            </a>
            <form action="{{ route('logout') }}" method="post" class="w-full">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-2 rounded-xl hover:bg-red-200 transition text-red-600 font-semibold">
                    <i class="fas fa-sign-out-alt mr-3"></i>Sign out
                </button>
            </form>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const closeBtn = document.getElementById('mobile-menu-close');
                const mobileMenu = document.getElementById('mobile-menu');
                const menuButton = document.getElementById('mobile-menu-button');
                let isOpen = false;

                menuButton?.addEventListener('click', function() {
                    isOpen = !isOpen;
                });

                closeBtn?.addEventListener('click', function(e) {
                    e.stopPropagation();
                    isOpen = false;
                    mobileMenu.classList.add('-translate-y-full');
                    mobileMenu.classList.remove('translate-y-0');
                    document.getElementById('top').setAttribute('d', 'M4 7h16');
                    document.getElementById('middle').setAttribute('d', 'M4 12h16');
                    document.getElementById('bottom').setAttribute('d', 'M4 17h16');
                });
            });
        </script>
    </div>
    <div id="ubahPasswordModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full bg-gray-900/80">
        <div class="relative w-full max-w-md h-full md:h-auto mx-auto mt-10 md:mt-24">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex justify-between items-center p-5 rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Ubah Password
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="ubahPasswordModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0
                 111.414 1.414L11.414 10l4.293 4.293a1 1 0
                 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0
                 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('changepassword', ['id' => encrypt(auth()->user()->id)]) }}" method="POST"
                    class="p-4">
                    @csrf
                    <div class="mb-2">
                        <label for="current_password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Password Saat Ini
                        </label>
                        <input type="password" name="current_password" id="current_password" required
                            placeholder="Masukkan Password Lama"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
               focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5
               dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                    </div>
                    <div class="mb-2">
                        <label for="new_password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Password Baru
                        </label>
                        <input type="password" name="new_password" id="new_password" required
                            placeholder="Masukkan Password Baru"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
               focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5
               dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                    </div>
                    <div class="mb-2">
                        <label for="new_password_confirmation"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            required placeholder="Confirm Password Baru"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
               focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5
               dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none
               focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5
               dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburger = document.getElementById('hamburger-icon');
            let isOpen = false;

            menuButton?.addEventListener('click', function(event) {
                event.stopPropagation();
                isOpen = !isOpen;
                if (isOpen) {
                    mobileMenu.classList.remove('-translate-y-full');
                    mobileMenu.classList.add('translate-y-0');
                    document.getElementById('top').setAttribute('d', 'M6 6l12 12');
                    document.getElementById('middle').setAttribute('d', '');
                    document.getElementById('bottom').setAttribute('d', 'M6 18L18 6');
                } else {
                    mobileMenu.classList.add('-translate-y-full');
                    mobileMenu.classList.remove('translate-y-0');
                    document.getElementById('top').setAttribute('d', 'M4 7h16');
                    document.getElementById('middle').setAttribute('d', 'M4 12h16');
                    document.getElementById('bottom').setAttribute('d', 'M4 17h16');
                }
            });
            document.addEventListener('click', function(event) {
                if (isOpen && !menuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    isOpen = false;
                    mobileMenu.classList.add('-translate-y-full');
                    mobileMenu.classList.remove('translate-y-0');
                    document.getElementById('top').setAttribute('d', 'M4 7h16');
                    document.getElementById('middle').setAttribute('d', 'M4 12h16');
                    document.getElementById('bottom').setAttribute('d', 'M4 17h16');
                }
            });
        });
    </script>
</nav>
