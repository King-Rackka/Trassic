<x-app-layout>
    <x-slot:title>Jelajahi Kreator Lainnya - Trassic</x-slot:title>

    <div class="w-full bg-white font-sans overflow-x-hidden selection:bg-[#ccff00] selection:text-black bg-grid-pattern relative min-h-screen flex flex-col justify-between">
        
        {{-- PITA SAYAP VEKTOR ATAS --}}
        <div class="w-full flex justify-between items-start pointer-events-none z-10 pt-0">
            <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Left" class="h-6 sm:h-12 object-contain">
            <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Right" class="h-6 sm:h-12 object-contain -scale-x-100">
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 w-full flex-1">
            
            {{-- BREADCRUMBS --}}
            <nav class="text-left pt-2 sm:pt-4 mb-4 sm:mb-6">
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest flex items-center gap-2">
                    <a href="{{ route('creators') }}" class="text-gray-500 hover:text-[#254bfe] hover:underline transition-colors">Creators</a> 
                    <span class="text-gray-400">/</span> 
                    <span class="text-[#254bfe] font-bold">Kreator lainnya</span>
                </p>
            </nav>

            <div class="text-center mb-8 sm:mb-12">
                <h1 class="font-display text-3xl sm:text-5xl text-[#254bfe] tracking-normal leading-tight">
                    Jelajahi Kreator Lainnya
                </h1>
            </div>

            <livewire:creators-more />

        </div>

        {{-- PITA SAYAP VEKTOR BAWAH --}}
        <div class="w-full flex justify-between items-end pointer-events-none z-10 pb-0 mt-8 sm:mt-12">
            <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Left" class="h-6 sm:h-12 object-contain">
            <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Right" class="h-6 sm:h-12 object-contain -scale-x-100">
        </div>

    </div>
</x-app-layout>