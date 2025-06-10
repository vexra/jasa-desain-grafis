<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang di Aplikasi Anda</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css') {{-- Pastikan ini memuat Tailwind CSS Anda --}}
    <style>
        /* Custom styles if needed, or primarily rely on Tailwind */
        .bg-hero-pattern {
            background-image: url('/images/hero-background.jpg'); /* Ganti dengan gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="antialiased font-sans bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="relative min-h-screen flex flex-col justify-between">
        {{-- Header / Auth Navigation --}}
        <header class="absolute top-0 right-0 p-6 z-10 w-full flex justify-end">
            @if (Route::has('login'))
                <nav class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500 transition duration-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500 transition duration-200">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500 transition duration-200">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        {{-- Hero Section --}}
        <section class="flex-grow flex items-center justify-center text-center p-8 bg-hero-pattern min-h-[60vh] md:min-h-[70vh] relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-50"></div> {{-- Overlay untuk readability --}}
            <div class="z-0 max-w-4xl mx-auto text-white relative">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-4 animate-fade-in-down">
                    Selamat Datang di <span class="text-indigo-400">Jasa Desain Grafis</span>
                </h1>
                <p class="text-lg md:text-xl mb-8 opacity-0 animate-fade-in-up" style="animation-delay: 0.3s;">
                    Solusi terbaik untuk mengelola pesanan dan daftar menu Anda dengan mudah dan efisien.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out opacity-0 animate-fade-in-up" style="animation-delay: 0.6s;">
                    Mulai Sekarang
                </a>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="py-16 px-8 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-12">Mengapa Memilih Kami?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <div class="h-16 w-16 bg-indigo-100 dark:bg-indigo-800 flex items-center justify-center rounded-full mx-auto mb-4">
                            <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M17 12l-2 2m-2-2l2-2m-2 2l-2-2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Manajemen Pesanan Mudah</h3>
                        <p class="text-gray-600 dark:text-gray-300">Pantau dan kelola semua pesanan Anda dari satu tempat dengan antarmuka yang intuitif.</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <div class="h-16 w-16 bg-indigo-100 dark:bg-indigo-800 flex items-center justify-center rounded-full mx-auto mb-4">
                            <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Daftar Menu Interaktif</h3>
                        <p class="text-gray-600 dark:text-gray-300">Lihat dan pesan dari daftar menu yang selalu terupdate.</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <div class="h-16 w-16 bg-indigo-100 dark:bg-indigo-800 flex items-center justify-center rounded-full mx-auto mb-4">
                            <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Profil yang Dipersonalisasi</h3>
                        <p class="text-gray-600 dark:text-gray-300">Kelola informasi pribadi dan preferensi Anda dengan mudah.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="py-8 text-center text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto">
                <p>&copy; {{ date('Y') }} Prave Inc. All rights reserved.</p>
                <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
            </div>
        </footer>
    </div>

    <style>
        /* Keyframe animations for hero section */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out forwards;
        }
    </style>
</body>
</html>