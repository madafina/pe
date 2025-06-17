<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIMBIMBEL - Sistem Informasi Bimbingan Belajar</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            {{-- Background Image --}}
            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop" alt="Latar Belakang Kantor" class="absolute inset-0 h-full w-full object-cover"/>
            
            {{-- Overlay Gelap --}}
            <div class="absolute inset-0 bg-black/60"></div>

            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-red-500 selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                           {{-- Logo atau Nama Aplikasi --}}
                           <h1 class="text-4xl font-bold text-white">SIMBIMBEL</h1>
                        </div>
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @if (Route::has('login'))
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-red-500"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-red-500"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-red-500"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </nav>
                    </header>

                    <main class="mt-20">
                        <div class="flex flex-col items-center justify-center text-center">
                            <h2 class="text-5xl lg:text-7xl font-extrabold text-white tracking-tight">
                                Kelola Bimbingan Belajar Anda Dengan Mudah
                            </h2>
                            <p class="mt-6 max-w-2xl text-lg text-gray-300">
                                Dari pendaftaran siswa, pengelolaan kelas, hingga notifikasi WhatsApp ke orang tua, semua dalam satu sistem yang terintegrasi.
                            </p>
                            <div class="mt-10">
                                <a href="{{ route('login') }}" 
                                   class="inline-block rounded-lg bg-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-900">
                                    Masuk ke Dasbor Admin
                                </a>
                            </div>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-white/70 mt-16">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
