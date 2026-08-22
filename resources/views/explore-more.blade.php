<x-app-layout>
    <x-slot:title>Karya Lainnya - Trassic</x-slot:title>

    <div class="w-full bg-white font-sans overflow-x-hidden selection:bg-[#ccff00] selection:text-black bg-grid-pattern relative min-h-screen flex flex-col justify-between">
        
        {{-- PITA SAYAP VEKTOR ATAS (LEBIH KECIL DI MOBILE: h-5) --}}
        <div class="w-full flex justify-between items-start pointer-events-none z-10 pt-0">
            <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Left" class="h-5 sm:h-12 object-contain">
            <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Right" class="h-5 sm:h-12 object-contain -scale-x-100">
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 w-full">
            
            {{-- Breadcrumbs Rata Kiri --}}
            <nav class="text-left mb-6">
                <p class="text-xs sm:text-sm font-semibold text-gray-500 uppercase tracking-widest flex items-center gap-2">
                    <a href="{{ route('explore') }}" class="hover:text-[#254bfe] hover:underline">Explore</a> 
                    <span class="text-gray-400">/</span> 
                    <span class="text-[#254bfe] font-bold">Karya lainnya</span>
                </p>
            </nav>

            {{-- Judul Utama Rata Tengah --}}
            <h1 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase text-center mb-8 tracking-normal">
                Hasil karya daur ulang
            </h1>

            <livewire:explore-more :category="request('category')" />
        </div>

        {{-- PITA SAYAP VEKTOR BAWAH (LEBIH KECIL DI MOBILE: h-5) --}}
        <div class="w-full flex justify-between items-end pointer-events-none z-10 pb-0 mt-12">
            <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Left" class="h-5 sm:h-12 object-contain">
            <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Right" class="h-5 sm:h-12 object-contain -scale-x-100">
        </div>

    </div>
</x-app-layout>