<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-100 via-white to-blue-200 min-h-screen flex items-center justify-center">
    <div class="fixed inset-0 bg-cover bg-center" style="background-image: url('{{ asset('assets/images/bg.jpg') }}');"></div>
    <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-lg p-6 sm:p-8 relative z-10">
        <div class="flex flex-col items-center mb-6">
            <div class="flex items-center justify-center gap-2 mb-2">
                <div
                    class="w-18 h-18  bg-white border border-gray-200 overflow-hidden flex items-center justify-center transition-transform transform hover:scale-105">
                    <img src="{{ asset('assets/images/logo_pu.jpg') }}" alt="Logo PU" class="w-16 h-16 object-cover"
                        onerror="this.onerror=null;this.src='https://placehold.co/80x80/CCCCCC/FFFFFF?text=Logo';">
                </div>
                <div
                    class="w-20 h-20 bg-white overflow-hidden flex items-center justify-center transition-transform transform hover:scale-105">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Cipta Karya"
                        class="w-24 h-24 object-contain"
                        onerror="this.onerror=null;this.src='https://placehold.co/80x80/CCCCCC/FFFFFF?text=Logo';">
                </div>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-1">Aplikasi Monitoring Paket</h2>
            <p class="text-sm text-gray-500 text-center">Dinas Pekerjaan Umum dan Tata Ruang</p>
            <p class="text-sm text-gray-500 text-center">Bidang Cipta Karya</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 p-3 rounded">
                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4" id="loginForm">
            @csrf
            <div>
                <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Username / Email</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" required
                    class="w-full border border-gray-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                    autocomplete="username" placeholder="Username / Email">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                    autocomplete="current-password" placeholder="Password">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Captcha</label>
                <div class="flex items-center gap-2">
                    <img src="{{ captcha_src() }}" alt="captcha"
                        class="h-10 rounded border border-gray-200 cursor-pointer"
                        onclick="this.src='{{ captcha_src() }}'+Math.random()">
                    <input type="text" name="captcha" placeholder="Enter Captcha" required
                        class="w-full border border-gray-200 rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg py-2 transition shadow">
                Login
            </button>
        </form>
    </div>
    <img src="{{ asset('assets/images/logo_mimika.png') }}" alt="Logo Mimika"
        class="fixed top-6 left-6 w-22 h-auto z-0 pointer-events-none select-none"
        onerror="this.onerror=null;this.src='https://placehold.co/112x112/CCCCCC/FFFFFF?text=Logo'">
    <script>
        const loginForm = document.getElementById('loginForm');
        loginForm.addEventListener('submit', function(event) {
            const loginInput = document.getElementById('login');
            const passwordInput = document.getElementById('password');
            if (!loginInput.value.trim() || !passwordInput.value.trim()) {
                event.preventDefault();
                alert('Username/Email dan Password wajib diisi.');
            }
        });
    </script>
</body>

</html>
