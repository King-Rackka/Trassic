<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Trassic' }}</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        .font-display {
            font-family: 'Anton', 'Impact', sans-serif;
            letter-spacing: 0.02em;
        }

        .bg-grid-pattern {
            background-image:
                linear-gradient(to right, #254bfe20 1px, transparent 1px),
                linear-gradient(to bottom, #254bfe20 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .can-scalable {
            height: clamp(280px, 62vh, 480px);
            width: auto;
        }

        @media (min-width: 1024px) and (min-height: 650px) {
            .can-scalable {
                height: clamp(340px, 68vh, 520px);
            }
        }

        @media (max-width: 638px) {
            .explore-banner-bg {
                border-style: solid;
                border-width: 170px 0px 60px 0px;
                border-image-source: url('/images/background-explore.png');
                border-image-slice: 480 100 120 100 fill;
                border-image-repeat: stretch;
            }
        }

        @media (min-width: 639px) {
            .explore-banner-bg {
                border-style: solid;
                border-width: 170px 0px 90px 0px;
                border-image-source: url('/images/background-explore.png');
                border-image-slice: 440 20 120 20 fill;
                border-image-repeat: stretch;
            }
        }

        @keyframes float-can {
            0%, 100% { transform: translateY(10px) scaleX(-1); }
            50% { transform: translateY(-20px) scaleX(-1); }
        }

        .animate-float {
            animation: float-can 4s ease-in-out infinite;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="antialiased bg-white font-sans selection:bg-[#ccff00] selection:text-black {{ ($fullscreen ?? false) ? 'h-screen overflow-hidden' : 'min-h-screen' }}">

<div class="flex flex-col {{ ($fullscreen ?? false) ? 'h-screen overflow-hidden' : 'min-h-screen' }}">

    {{-- NAVBAR --}}
    <header class="w-full bg-white border-b-2 border-[#254bfe] z-30 relative shrink-0" x-data="{ mobileMenuOpen: false }">
        <div class="w-full flex items-center justify-between">

            {{-- Logo --}}
            <div class="px-6 lg:px-10 py-3.5 flex items-center bg-white justify-start">
                <img src="{{ asset('images/logo.png') }}" alt="Trassic" class="h-8 object-contain" onerror="this.src='https://via.placeholder.com/120x35/254bfe/ffffff?text=Trassic'">
            </div>

            {{-- Nav Desktop --}}
            <div class="hidden xl:flex w-1/2 bg-[#254bfe] px-6 lg:px-8 py-3.5 items-center justify-between">
                <nav class="flex items-center gap-3 xl:gap-5 text-white font-display text-xs xl:text-base uppercase tracking-wide min-w-0">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-[#ccff00]' : '' }} hover:text-[#ccff00] transition whitespace-nowrap">Beranda</a>
                    <a href="{{ route('explore') }}" class="{{ request()->routeIs('explore') ? 'text-[#ccff00]' : '' }} hover:text-[#ccff00] transition whitespace-nowrap">Explore</a>
                    <a href="#" class="hover:text-[#ccff00] transition whitespace-nowrap">Waste &amp; Impact</a>
                    <a href="{{ route('creators') }}" class="{{ request()->routeIs('creators') ? 'text-[#ccff00]' : '' }} hover:text-[#ccff00] transition whitespace-nowrap">Creators</a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-[#ccff00]' : '' }} hover:text-[#ccff00] transition whitespace-nowrap">About</a>
                </nav>
                <div class="flex items-center gap-2 font-display shrink-0 ml-2">
    @guest
        <a href="{{ route('login') }}" class="bg-[#ccff00] text-[#2f3cff] px-3 py-1 uppercase text-xs xl:text-base hover:bg-opacity-90 transition">Login</a>
        <a href="{{ route('register') }}" class="bg-[#ff007a] text-[#ccff00] px-3 py-1 uppercase text-xs xl:text-base hover:bg-opacity-90 transition">Register</a>
    @else
        <span class="text-white text-xs xl:text-base">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-[#ff007a] text-[#ccff00] px-3 py-1 uppercase text-xs xl:text-base hover:bg-opacity-90 transition">
                Logout
            </button>
        </form>
    @endguest
</div>
            </div>

            {{-- Hamburger Mobile --}}
            <div class="flex xl:hidden px-6 py-3.5 items-center justify-end">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="bg-[#f2f4f7] hover:bg-gray-200 text-[#254bfe] p-2 rounded-xl transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" x-cloak/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Dropdown Mobile (Menu & Tombol Rata Tengah / Atas-Bawah) --}}
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.away="mobileMenuOpen = false"
             class="absolute top-full left-0 w-full bg-[#254bfe] border-b-4 border-indigo-950 p-6 flex flex-col gap-6 xl:hidden z-50 shadow-xl text-center" x-cloak>
            
            {{-- Navigasi Mobile Rata Tengah --}}
            <nav class="flex flex-col gap-4 text-white font-display text-xl uppercase tracking-wider items-center justify-center">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-[#ccff00]' : '' }} hover:text-[#ccff00] transition">Beranda</a>
                <a href="{{ route('explore') }}" class="{{ request()->routeIs('explore') ? 'text-[#ccff00]' : '' }} hover:text-[#ccff00] transition">Explore</a>
                <a href="#" class="hover:text-[#ccff00] transition">Waste &amp; Impact</a>
                <a href="#" class="hover:text-[#ccff00] transition">Creators</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-[#ccff00]' : '' }} hover:text-[#ccff00] transition">About</a>
            </nav>

            {{-- Tombol Login & Register Bertumpuk Atas-Bawah Rata Tengah --}}
            <div class="flex flex-col gap-3 font-display pt-4 border-t border-blue-400/50 w-full max-w-xs mx-auto">
                <a href="{{ route('login') }}" class="w-full text-center bg-[#ccff00] text-[#254bfe] py-2.5 uppercase text-lg font-bold hover:bg-opacity-90 transition">Login</a>
                <a href="{{ route('register') }}" class="w-full text-center bg-[#ff007a] text-[#ccff00] py-2.5 uppercase text-lg font-bold hover:bg-opacity-90 transition">Register</a>
            </div>
        </div>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 flex flex-col lg:flex-row min-h-0 {{ ($fullscreen ?? false) ? 'overflow-hidden' : '' }}">
        {{ $slot }}
    </main>

    {{-- FOOTER (Hanya muncul jika bukan halaman fullscreen/login) --}}
    @if (!($fullscreen ?? false))
        <footer class="w-full bg-[#F3F1EA] border-t-4 border-[#254bfe] shrink-0">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 py-12 lg:py-16 flex flex-col md:flex-row md:items-center md:justify-between gap-8">

                {{-- Logo + Copyright --}}
                <div class="flex flex-col gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Trassic" class="h-10 lg:h-12 object-contain w-fit" onerror="this.src='https://via.placeholder.com/120x35/254bfe/ffffff?text=Trassic'">
                    <p class="text-sm lg:text-base font-semibold text-[#254bfe]">©{{ date('Y') }}, by FENDI RAJA ELANG</p>
                </div>

                {{-- Nav --}}
                <nav class="flex flex-wrap items-center gap-x-8 gap-y-3 text-[#254bfe] font-display text-base lg:text-xl uppercase tracking-wide">
                    <a href="{{ url('/') }}" class="hover:text-[#ff007a] transition whitespace-nowrap">Beranda</a>
                    <a href="{{ route('explore') }}" class="hover:text-[#ff007a] transition whitespace-nowrap">Explore</a>
                    <a href="{{ Route::has('waste-impact') ? route('waste-impact') : '#' }}" class="hover:text-[#ff007a] transition whitespace-nowrap">Waste &amp; Impact</a>
                    <a href="{{ Route::has('creators') ? route('creators') : '#' }}" class="hover:text-[#ff007a] transition whitespace-nowrap">Creators</a>
                    <a href="{{ route('about') }}" class="hover:text-[#ff007a] transition whitespace-nowrap">About</a>
                </nav>

                {{-- Login / Register --}}
                <div class="flex items-center gap-3 font-display shrink-0">
                    <a href="{{ route('login') }}" class="bg-[#ccff00] text-[#254bfe] px-5 py-2.5 uppercase text-base lg:text-lg font-bold hover:bg-opacity-90 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-[#ff007a] text-[#ccff00] px-5 py-2.5 uppercase text-base lg:text-lg font-bold hover:bg-opacity-90 transition">Register</a>
                </div>

            </div>
        </footer>
    @endif

</div>
@stack('scripts')

<x-login-prompt-modal />

</body>
</html>