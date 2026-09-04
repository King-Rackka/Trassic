<x-app-layout>
    <x-slot:title>About - Trassic</x-slot:title>

    @push('scripts')
        @viteReactRefresh
        @vite(['resources/js/react-entries/about-hero.jsx'])
    @endpush

    <div class="w-full bg-grid-pattern font-sans overflow-x-hidden selection:bg-[#D9FC28] selection:text-[#2F3AFF] relative min-h-screen flex flex-col justify-between">

        <style>
            @keyframes spin-slow {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .animate-spin-slow {
                animation: spin-slow 12s linear infinite;
            }

            @keyframes float-slow {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-16px); }
            }
            .animate-float {
                animation: float-slow 4s ease-in-out infinite;
            }

            .filter-blue-trassic {
                filter: invert(21%) sepia(93%) saturate(3821%) hue-rotate(228deg) brightness(98%) contrast(106%);
            }
        </style>

        <section class="relative w-full overflow-hidden bg-gradient-to-r from-[#D9FC28] via-[#ff8a4c] to-[#FC00BB] border-y-4 border-[#2F3AFF]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">

                    {{-- Teks Kiri (Rata Tengah di HP, Rata Kiri di Desktop) --}}
                    <div class="md:col-span-4 text-center md:text-left">
                        <h1 class="relative font-display leading-[0.9] tracking-normal text-[#2F3AFF] text-4xl sm:text-6xl lg:text-7xl">
                            <span class="invisible" aria-hidden="true">
                                NICE<br>RECYCLE<br>GALLERY<br>ART<br>HERE
                            </span>
                            <span id="about-hero-typetext-left" class="absolute inset-0 text-center md:text-left"></span>
                        </h1>
                    </div>

                    {{-- Piringan Hitam Spin (Ukuran Pas untuk HP) --}}
                    <div class="md:col-span-4 flex justify-center items-center my-4 md:my-0">
                        <div class="w-52 h-52 sm:w-72 sm:h-72 lg:w-96 lg:h-96 animate-spin-slow">
                            <img src="{{ asset('images/vector/Vector_Landingpage_1.png') }}" alt="Vinyl Record" class="w-full h-full object-contain">
                        </div>
                    </div>

                    {{-- Teks Kanan (Di HP Tampil di Bawah Piringan Rata Tengah, Di Desktop Rata Kanan) --}}
                    <div class="md:col-span-4 text-center md:text-right">
                        <h1 class="relative font-display leading-[0.9] tracking-normal text-[#D9FC28] [-webkit-text-stroke:1.5px_#2F3AFF] text-4xl sm:text-6xl lg:text-7xl">
                            <span class="invisible" aria-hidden="true">
                                NICE<br>RECYCLE<br>GALLERY<br>ART<br>HERE
                            </span>
                            <span id="about-hero-typetext-right" class="absolute inset-0 text-center md:text-right"></span>
                        </h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24 relative" x-data="{ 
            currentDev: 0,
            developers: [
                {
                    name: 'Muhammad Daffa Syarif Syaddad',
                    role: 'UI/UX Designer & Team Leader',
                    nim: '2407411015',
                    instansi: 'POLITEKNIK NEGERI JAKARTA',
                    phone: '0895373172879',
                    email: 'example.com',
                    number: '#1',
                    image: '{{ asset('images/creators/daffa.png') }}'
                },
                {
                    name: 'Raditya Meyka Harry Sandhiva',
                    role: 'Developer 1',
                    nim: '2407411014',
                    instansi: 'POLITEKNIK NEGERI JAKARTA',
                    phone: '081513175617',
                    email: 'radityameyka5@gmail.com',
                    number: '#2',
                    image: '{{ asset('images/creators/radit.jpeg') }}'
                },
                {
                    name: 'Muhammad Fahreza Prasetya Ramadhan',
                    role: 'Developer 2',
                    nim: '2407411016',
                    instansi: 'POLITEKNIK NEGERI JAKARTA',
                    phone: '0895111111111',
                    email: 'developer3@gmail.com',
                    number: '#3',
                    image: '{{ asset('images/creators/reza.png') }}'
                }
            ],
            nextDev() {
                this.currentDev = (this.currentDev + 1) % this.developers.length;
            }
        }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <h2 class="font-display text-3xl sm:text-5xl text-[#2F3AFF] text-center mb-12 tracking-wide">
                    Meet the Creator
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <div class="lg:col-span-7 flex flex-col items-center">
                        <div @click="nextDev()" 
                             class="relative w-full max-w-[500px] cursor-pointer group select-none transition-transform hover:scale-[1.01]">
                            
                            <img src="{{ asset('images/template-tv.png') }}" alt="TV Frame" class="w-full relative z-20 pointer-events-none">

                            <div class="absolute top-[12%] left-[12%] w-[76%] h-[68%] z-10 overflow-hidden bg-black flex items-center justify-center">
                                <template x-for="(dev, index) in developers" :key="index">
                                    <img :src="dev.image" 
                                         x-show="currentDev === index"
                                         x-transition:enter="transition opacity duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         class="w-full h-full object-cover"
                                         alt="Creator Photo">
                                </template>

                                <div class="absolute bottom-2 right-2 z-30 bg-[#2F3AFF] text-[#D9FC28] text-[10px] font-bold px-2 py-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    Klik Layar TV ➔
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-4">
                        
                        <div>
                            <div class="bg-[#FC00BB] px-5 py-3 border-2 border-[#FC00BB] inline-block w-full">
                                <h3 class="font-display text-1xl sm:text-2xl text-[#D9FC28] tracking-normal" 
                                    x-text="developers[currentDev].number + ' ' + developers[currentDev].name">
                                </h3>
                            </div>
                            <p class="font-display text-xl text-[#2F3AFF] mt-2" x-text="developers[currentDev].role"></p>
                        </div>

                        <div class="border-2 border-[#FC00BB] bg-[#F8F9FA] p-3 sm:p-6 shadow-[6px_6px_0px_#2F3AFF] font-sans">
                            <h4 class="font-display text-xl sm:text-2xl text-[#2F3AFF] mb-3">Detail</h4>
                            
                            <table class="w-full text-[10px] sm:text-sm text-[#2F3AFF] font-bold border-separate border-spacing-y-2">
                                <tbody>
                                    <tr>
                                        <td class="whitespace-nowrap align-top pr-2 w-1">NIM</td>
                                        <td class="align-top w-1 pr-2">:</td>
                                        <td class="font-normal align-top" x-text="developers[currentDev].nim"></td>
                                    </tr>

                                    <tr>
                                        <td class="whitespace-nowrap align-top pr-2 w-1">Institusi</td>
                                        <td class="align-top w-1 pr-2">:</td>
                                        <td class="font-normal align-top" x-text="developers[currentDev].instansi"></td>
                                    </tr>

                                    <tr>
                                        <td class="whitespace-nowrap align-top pr-2 w-1">Nomor Telepon</td>
                                        <td class="align-top w-1 pr-2">:</td>
                                        <td class="font-normal align-top" x-text="developers[currentDev].phone"></td>
                                    </tr>

                                    <tr>
                                        <td class="whitespace-nowrap align-top pr-2 w-1">Email</td>
                                        <td class="align-top w-1 pr-2">:</td>
                                        <td class="font-normal align-top break-all" x-text="developers[currentDev].email"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>
        </section>


        <section class="py-16 sm:py-24 relative border-t-2 border-[#2F3AFF]/20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex items-center justify-center gap-3 mb-12 flex-wrap">
                    <h2 class="font-display text-3xl sm:text-5xl text-[#2F3AFF]">
                        Apa itu
                    </h2>
                    <img src="{{ asset('images/logo.png') }}" alt="Trassic Logo" class="h-10 sm:h-14 object-contain inline-block">
                    <h2 class="font-display text-3xl sm:text-5xl text-[#2F3AFF]">?</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <div class="lg:col-span-8">
                        <div class="border-2 border-[#FC00BB] bg-white p-6 sm:p-10 shadow-[6px_6px_0px_#2F3AFF] relative">
                            <p class="font-sans text-sm sm:text-base md:text-lg text-[#2F3AFF] leading-relaxed font-medium">
                                <strong class="text-[#2F3AFF] font-bold">TRASSIC</strong> wadah galeri digital yang mendokumentasikan karya seni dari bahan sampah dan material bekas. Mempermudah kreator, komunitas, dan pengrajin dalam mempublikasikan berbagai hasil karya daur ulang yang bernilai, dengan rekam jejak material sampah bersih yang jelas, transparan, serta dapat menginspirasi khalayak luas.
                            </p>
                        </div>
                    </div>

                    <div class="lg:col-span-4 flex justify-center">
                        <div class="relative w-48 sm:w-64 animate-float">
                            <img src="{{ asset('images/kantung-sampah.png') }}" 
                                 alt="Kantung Sampah Trassic" 
                                 class="w-full h-auto object-contain filter-blue-trassic">
                        </div>
                    </div>

                </div>

            </div>
        </section>


        <section class="py-16 sm:py-24 relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <h2 class="font-display text-3xl sm:text-5xl text-[#2F3AFF] mb-12 text-center tracking-wide">
                    Frequently Asked Questions (FAQ)
                </h2>

                @php
                    $faqs = [
                        [
                            'q' => 'Who can submit a work?',
                            'a' => 'Anyone with a TRASSIC account can submit a work — individual creators, artists, and members of a registered community or organization.',
                        ],
                        [
                            'q' => 'Can communities submit works?',
                            'a' => 'Yes. A work can be associated with a community, alongside the individual creator who submits it on the community\'s behalf.',
                        ],
                        [
                            'q' => 'Is TRASSIC a marketplace?',
                            'a' => 'No. TRASSIC is a documentation and discovery platform, not a marketplace. Creators may share contact or social links on their profile, but transactions happen outside the platform.',
                        ],
                        [
                            'q' => 'How is impact calculated?',
                            'a' => 'Impact figures are aggregated only from published works\' reported waste data. They reflect documented activity on TRASSIC, not independently verified environmental impact.',
                        ],
                        [
                            'q' => 'Can i edit my submitted work?',
                            'a' => 'Yes, from your dashboard. Key fields may be locked while a work is under review to keep the moderation process consistent.',
                        ],
                    ];
                @endphp

                <div class="divide-y-2 divide-[#2F3AFF] border-y-2 border-[#2F3AFF]" x-data="{ open: null }">
                    @foreach ($faqs as $i => $faq)
                        <div class="py-5">
                            <button
                                type="button"
                                @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                                class="w-full flex items-center justify-between text-left py-2 focus:outline-none cursor-pointer"
                            >
                                <span class="font-bold text-[#2F3AFF] text-lg sm:text-2xl font-sans">{{ $faq['q'] }}</span>
                                
                                {{-- ICON BULAT LIME khas UI REFERENCE GAMBAR 3 --}}
                                <div class="w-8 h-8 rounded-full bg-[#D9FC28] border-2 border-[#2F3AFF] flex items-center justify-center shrink-0 ml-4">
                                    <span class="font-bold text-xl text-[#2F3AFF] leading-none" x-text="open === {{ $i }} ? '−' : '+'"></span>
                                </div>
                            </button>
                            
                            <div x-show="open === {{ $i }}" x-collapse class="pt-3 pb-4 text-xs sm:text-base text-[#2F3AFF] leading-relaxed font-sans font-medium">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- ========================================== --}}
        {{-- SECTION 5: FOOTER BACKGROUND KOTA SILUET   --}}
        {{-- ========================================== --}}
        <div class="w-full relative pointer-events-none mt-12 overflow-hidden">
            <img src="{{ asset('images/bg-kota.png') }}" alt="Background Skyline Kota Trassic" class="w-full h-auto object-cover min-h-[160px]">
        </div>

    </div>
</x-app-layout>