<x-app-layout>
    <x-slot:title>About - Trassic</x-slot:title>

    @push('scripts')
        @viteReactRefresh
        @vite(['resources/js/react-entries/about-hero.jsx'])
    @endpush

    <div class="w-full bg-white font-sans overflow-x-hidden selection:bg-[#ccff00] selection:text-black relative min-h-screen flex flex-col justify-between">

        {{-- ============================= --}}
        {{-- HERO — mengikuti pola desain About.png (mirrored big text di atas gradient) --}}
        {{-- ============================= --}}
        <section class="relative w-full overflow-hidden bg-gradient-to-br from-[#ccff00] via-[#ff8a4c] to-[#ff00b8]">

            {{-- PITA SAYAP VEKTOR ATAS --}}
            <div class="w-full flex justify-between items-start pointer-events-none z-10 pt-0 absolute top-0 left-0">
                <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Left" class="h-5 sm:h-12 object-contain">
                <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Right" class="h-5 sm:h-12 object-contain -scale-x-100">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 sm:pt-56 pb-20 sm:pb-52">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">

                    {{-- Kolom kiri: headline warna biru, animasi typing via React (TextType) --}}
                    <h1 class="relative font-display uppercase leading-[0.9] tracking-normal text-[#254bfe] text-4xl sm:text-6xl lg:text-7xl text-left">
                        {{-- Ghost text: invisible, tapi tetap makan ruang supaya tinggi h1 fix dari awal --}}
                        <span class="invisible" aria-hidden="true">
                            WASTE<br>ISN'T THE<br>END OF<br>THE STORY
                        </span>
                        {{-- Teks animasi ditumpuk di atas ghost text --}}
                        <span id="about-hero-typetext-left" class="absolute inset-0 text-left"></span>
                    </h1>

                    {{-- Kolom kanan: headline warna lime, rata kanan (efek mirror seperti desain) --}}
                    <h1 class="relative font-display uppercase leading-[0.9] tracking-normal text-[#ccff00] [-webkit-text-stroke:1.5px_#121210] text-4xl sm:text-6xl lg:text-7xl text-right hidden lg:block">
                        <span class="invisible" aria-hidden="true">
                            WASTE<br>ISN'T THE<br>END OF<br>THE STORY
                        </span>
                        <span id="about-hero-typetext-right" class="absolute inset-0 text-right"></span>
                    </h1>

                </div>

                
            </div>
        </section>

        

        {{-- ============================= --}}
        {{-- FAQ --}}
        {{-- ============================= --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 w-full">
            <h2 class="font-display uppercase text-2xl sm:text-4xl text-[#254bfe] mb-10 text-center">
                Frequently Asked Questions
            </h2>

            @php
                $faqs = [
                    [
                        'q' => 'What is TRASSIC?',
                        'a' => 'TRASSIC is a digital gallery documenting creative works made from waste and discarded materials — showcasing the creators, the process, and the materials behind each piece.',
                    ],
                    [
                        'q' => 'Who can submit a work?',
                        'a' => 'Anyone with a TRASSIC account can submit a work — individual creators, artists, and members of a registered community or organization.',
                    ],
                    [
                        'q' => 'Can communities submit works?',
                        'a' => 'Yes. A work can be associated with a community, alongside the individual creator who submits it on the community\'s behalf.',
                    ],
                    [
                        'q' => 'What materials can be submitted?',
                        'a' => 'Any work made from discarded or repurposed materials — plastic, textile, glass, metal, and more — as long as the waste origin (Waste DNA) is documented.',
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
                        'q' => 'Can I edit my submitted work?',
                        'a' => 'Yes, from your dashboard. Key fields may be locked while a work is under review to keep the moderation process consistent.',
                    ],
                    [
                        'q' => 'How does moderation work?',
                        'a' => 'Every submission is reviewed by the TRASSIC team before publishing. You\'ll be notified if your work is approved, needs revision, or is rejected — with feedback provided.',
                    ],
                ];
            @endphp

            <div class="space-y-3" x-data="{ open: null }">
                @foreach ($faqs as $i => $faq)
                    <div class="border-2 border-[#121210] rounded-[6px] overflow-hidden">
                        <button
                            type="button"
                            @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                            class="w-full flex items-center justify-between text-left px-5 py-4 bg-[#F3F1EA] hover:bg-[#EAE6DC] transition-colors"
                        >
                            <span class="font-semibold text-[#121210]">{{ $faq['q'] }}</span>
                            <span class="font-display text-xl text-[#254bfe]" x-text="open === {{ $i }} ? '−' : '+'"></span>
                        </button>
                        <div x-show="open === {{ $i }}" x-collapse class="px-5 py-4 text-sm text-[#2B2B27] leading-relaxed bg-white">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- PITA SAYAP VEKTOR BAWAH --}}
        <div class="w-full flex justify-between items-end pointer-events-none z-10 pb-0 mt-4">
            <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Left" class="h-5 sm:h-12 object-contain">
            <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Right" class="h-5 sm:h-12 object-contain -scale-x-100">
        </div>

    </div>
</x-app-layout>