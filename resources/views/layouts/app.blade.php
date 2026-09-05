<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Trassic' }}</title>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        .font-display {
            font-family: 'Impact', 'Arial Black', 'Helvetica Compressed', sans-serif !important;
            letter-spacing: 0.03em; 
        }
        .font-sans, body {
            font-family: 'Inter', 'Helvetica', 'Arial', sans-serif !important;
        }

        .bg-grid-pattern {
            background-image:
                linear-gradient(to right, rgba(47, 58, 255, 0.12) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(47, 58, 255, 0.12) 1px, transparent 1px);
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

<body class="antialiased bg-white font-sans selection:bg-[#D9FC28] selection:text-[#2F3AFF] {{ ($fullscreen ?? false) ? 'h-screen overflow-hidden' : 'min-h-screen' }}">

<div class="flex flex-col {{ ($fullscreen ?? false) ? 'h-screen overflow-hidden' : 'min-h-screen' }}">

<header class="w-full border-b-2 border-[#2F3AFF] z-40 fixed top-0 left-0 bg-white transition-transform duration-300"
        x-data="{ 
            mobileMenuOpen: false, 
            userDropdownOpen: false,
            navVisible: true,
            scrollTimer: null,
            init() {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        this.navVisible = false;
                    } else {
                        this.navVisible = true;
                    }
                    clearTimeout(this.scrollTimer);
                    this.scrollTimer = setTimeout(() => {
                        this.navVisible = true;
                    }, 250);
                });
            }
        }"
        :class="navVisible ? 'translate-y-0' : '-translate-y-full'">
    
    <div class="w-full flex items-stretch justify-between h-16">

        <div class="w-full xl:w-1/2 flex items-center justify-between gap-2 sm:gap-4 px-3 sm:px-6 lg:px-8 bg-white shrink-0 min-w-0">
            <a href="{{ url('/') }}" class="shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="Trassic" class="h-7 sm:h-8 object-contain" onerror="this.src='https://via.placeholder.com/120x35/2F3AFF/ffffff?text=Trassic'">
            </a>

            <form action="{{ route('search') }}" method="GET" class="flex-1 min-w-0">
                <div class="relative flex items-center w-full">
                    <button type="submit" class="absolute left-3 text-[#2F3AFF] hover:text-[#FC00BB] transition cursor-pointer z-10">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 fill-none stroke-current" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Cari karya daur ulang" 
                           class="w-full bg-[#F8F8F8] border-2 border-[#2F3AFF] text-[#2F3AFF] text-xs font-medium pl-8 sm:pl-9 pr-2 sm:pr-3 py-1.5 focus:outline-none placeholder-[#2F3AFF]/50">
                </div>
            </form>

            <button @click.stop="mobileMenuOpen = !mobileMenuOpen"
                    type="button"
                    class="xl:hidden bg-[#f2f4f7] hover:bg-gray-200 text-[#2F3AFF] p-2 rounded-lg transition focus:outline-none cursor-pointer shrink-0 ml-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" x-cloak/>
                </svg>
            </button>
        </div>


        <div class="hidden xl:flex w-1/2 bg-[#2F3AFF] px-6 lg:px-8 py-3.5 items-center justify-between shrink-0 gap-4 xl:gap-6">
            
            <nav class="flex items-center gap-4 xl:gap-6 text-white font-display text-xs xl:text-sm uppercase tracking-tight shrink-0">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition whitespace-nowrap">Beranda</a>
                <a href="{{ route('explore') }}" class="{{ request()->routeIs('explore') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition whitespace-nowrap">Explore</a>
                <a href="{{ Route::has('creators') ? route('creators') : '#' }}" class="{{ request()->routeIs('creators') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition whitespace-nowrap">Creators</a>
                <a href="#" class="hover:text-[#D9FC28] transition whitespace-nowrap">Waste &amp; Impact</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition whitespace-nowrap">About</a>
            </nav>
            
            <div class="flex-1 flex items-center justify-end font-display shrink-0 relative min-w-0">
                @guest
                    <div class="flex items-center justify-end gap-2 w-full">
                        <a href="{{ route('login') }}" class="flex-1 max-w-[100px] text-center bg-[#D9FC28] text-[#2F3AFF] px-3 py-1 uppercase text-xs xl:text-sm hover:bg-opacity-90 transition whitespace-nowrap">Login</a>
                        <a href="{{ route('register') }}" class="flex-1 max-w-[110px] text-center bg-[#FC00BB] text-[#D9FC28] px-3 py-1 uppercase text-xs xl:text-sm hover:bg-opacity-90 transition whitespace-nowrap">Register</a>
                    </div>
                @else
                    <div class="relative flex items-center justify-end w-full">
                        <button @click="userDropdownOpen = !userDropdownOpen" 
                                @click.away="userDropdownOpen = false"
                                type="button" 
                                class="group relative flex items-center justify-end cursor-pointer transition-transform hover:scale-105 w-full">
                            
                            {{-- Lingkaran Foto / Inisial --}}
                            <div class="w-9 h-9 xl:w-10 xl:h-10 rounded-full border-2 border-[#FC00BB] overflow-hidden bg-[#2F3AFF] z-10 shrink-0 flex items-center justify-center">
                                @if (auth()->user()->profile_image)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-[#D9FC28] font-display text-xs xl:text-sm">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                    </span>
                                @endif
                            </div>

                            <div class="-ml-4 bg-[#D9FC28] text-[#FC00BB] font-sans text-xs xl:text-sm font-bold tracking-normal rounded-r-full pl-6 pr-4 py-1.5 flex items-center justify-center flex-1 min-w-[120px] text-center">
                                <span class="truncate">{{ Str::words(auth()->user()->name, 10, '') }}</span>
                            </div>
                        </button>

                        <div x-show="userDropdownOpen" 
                             x-cloak
                             x-transition
                             class="absolute right-0 top-full mt-2 w-48 bg-white border-2 border-[#FC00BB] z-50 p-1.5 space-y-1 shadow-lg">
                            
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-2.5 py-2 text-[#2F3AFF] hover:bg-[#D9FC28] hover:text-black font-display text-xs uppercase tracking-wide transition-colors border border-transparent hover:border-black">
                                <svg class="w-3.5 h-3.5 shrink-0 fill-current" viewBox="0 0 24 24"><path d="M4 11h6a1 1 0 001-1V4a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1zm10 0h6a1 1 0 001-1V4a1 1 0 00-1-1h-6a1 1 0 00-1 1v6a1 1 0 001 1zM4 21h6a1 1 0 001-1v-6a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1zm10 0h6a1 1 0 001-1v-6a1 1 0 00-1-1h-6a1 1 0 00-1 1v6a1 1 0 001 1z"/></svg>
                                <span>Dashboard</span>
                            </a>

                            <a href="{{ Route::has('profile.show') ? route('profile.show') : '#' }}" 
                               class="flex items-center gap-2.5 px-2.5 py-2 text-[#2F3AFF] hover:bg-[#D9FC28] hover:text-black font-display text-xs uppercase tracking-wide transition-colors border border-transparent hover:border-black">
                                <svg class="w-3.5 h-3.5 shrink-0 stroke-current fill-none" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Profile Saya</span>
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-2.5 py-2 text-[#FC00BB] hover:bg-[#FC00BB] hover:text-white font-display text-xs uppercase tracking-wide transition-colors border border-transparent hover:border-black cursor-pointer">
                                    <svg class="w-3.5 h-3.5 shrink-0 stroke-current fill-none" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

        </div>
    </div>

    {{-- DROPDOWN MENU MOBILE --}}
    <div x-show="mobileMenuOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="mobileMenuOpen = false"
         class="absolute top-full left-0 w-full bg-[#2F3AFF] border-b-4 border-indigo-950 p-6 flex flex-col gap-6 xl:hidden z-50 shadow-xl text-center">
        
        <nav class="flex flex-col gap-4 text-white font-display text-lg uppercase tracking-wider items-center justify-center">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition">Beranda</a>
            <a href="{{ route('explore') }}" class="{{ request()->routeIs('explore') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition">Explore</a>
            <a href="{{ Route::has('creators') ? route('creators') : '#' }}" class="{{ request()->routeIs('creators') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition">Creators</a>
            <a href="#" class="hover:text-[#D9FC28] transition">Waste &amp; Impact</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-[#D9FC28]' : '' }} hover:text-[#D9FC28] transition">About</a>
        </nav>

        <div class="flex flex-col gap-3 font-display pt-4 border-t border-blue-400/50 w-full max-w-xs mx-auto">
            @guest
                <a href="{{ route('login') }}" class="w-full text-center bg-[#D9FC28] text-[#2F3AFF] py-2.5 uppercase text-base font-bold hover:bg-opacity-90 transition">Login</a>
                <a href="{{ route('register') }}" class="w-full text-center bg-[#FC00BB] text-[#D9FC28] py-2.5 uppercase text-base font-bold hover:bg-opacity-90 transition">Register</a>
            @else
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2.5 bg-white text-[#2F3AFF] py-2.5 uppercase text-base font-display border-2 border-[#FC00BB]">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M4 11h6a1 1 0 001-1V4a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1zm10 0h6a1 1 0 001-1V4a1 1 0 00-1-1h-6a1 1 0 00-1 1v6a1 1 0 001 1zM4 21h6a1 1 0 001-1v-6a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1zm10 0h6a1 1 0 001-1v-6a1 1 0 00-1-1h-6a1 1 0 00-1 1v6a1 1 0 001 1z"/></svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ Route::has('profile.show') ? route('profile.show') : '#' }}" class="flex items-center justify-center gap-2.5 bg-white text-[#2F3AFF] py-2.5 uppercase text-base font-display border-2 border-[#FC00BB]">
                    <svg class="w-5 h-5 stroke-current fill-none" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profile Saya</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2.5 bg-[#FC00BB] text-[#D9FC28] py-2.5 uppercase text-base font-display border-2 border-black cursor-pointer">
                        <svg class="w-5 h-5 stroke-current fill-none" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Logout</span>
                    </button>
                </form>
            @endguest
        </div>
    </div>
</header>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 flex flex-col lg:flex-row min-h-0 pt-16 {{ ($fullscreen ?? false) ? 'overflow-hidden' : '' }}">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    @if (!($fullscreen ?? false))
        <footer class="w-full bg-[#F3F1EA] border-t-4 border-[#2F3AFF] shrink-0">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10 lg:py-14 flex flex-col md:flex-row md:items-center md:justify-between gap-8">

                <div class="flex flex-col gap-2 items-center md:items-start text-center md:text-left">
                    <img src="{{ asset('images/logo.png') }}" alt="Trassic" class="h-10 lg:h-12 object-contain w-fit" onerror="this.src='https://via.placeholder.com/120x35/2F3AFF/ffffff?text=Trassic'">
                    <p class="text-sm lg:text-base font-semibold text-[#2F3AFF]">©{{ date('Y') }}, by FENDI RAJA ELANG</p>
                </div>

                <nav class="flex flex-wrap items-center justify-center gap-x-6 lg:gap-x-8 gap-y-3 text-[#2F3AFF] font-display text-base lg:text-xl uppercase tracking-wide">
                    <a href="{{ url('/') }}" class="hover:text-[#FC00BB] transition whitespace-nowrap">Beranda</a>
                    <a href="{{ route('explore') }}" class="hover:text-[#FC00BB] transition whitespace-nowrap">Explore</a>
                    <a href="{{ Route::has('waste-impact') ? route('waste-impact') : '#' }}" class="hover:text-[#FC00BB] transition whitespace-nowrap">Waste &amp; Impact</a>
                    <a href="{{ Route::has('creators') ? route('creators') : '#' }}" class="hover:text-[#FC00BB] transition whitespace-nowrap">Creators</a>
                    <a href="{{ route('about') }}" class="hover:text-[#FC00BB] transition whitespace-nowrap">About</a>
                </nav>

                <div class="flex items-center justify-center gap-3 font-display shrink-0">
                    @guest
                        <a href="{{ route('login') }}" class="bg-[#D9FC28] text-[#2F3AFF] px-3 xl:px-4 py-1 uppercase text-xs xl:text-sm hover:bg-opacity-90 transition whitespace-nowrap">Login</a>
                        <a href="{{ route('register') }}" class="bg-[#FC00BB] text-[#D9FC28] px-3 xl:px-4 py-1 uppercase text-xs xl:text-sm hover:bg-opacity-90 transition whitespace-nowrap">Register</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-[#D9FC28] text-[#2F3AFF] px-3 xl:px-4 py-1 uppercase text-base lg:text-lg hover:bg-opacity-90 transition">Dashboard</a>
                    @endguest
                </div>

            </div>
        </footer>
    @endif

</div>
@stack('scripts')

<x-login-prompt-modal />
@livewireScripts

</body>
</html>