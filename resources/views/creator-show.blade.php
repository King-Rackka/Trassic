<x-app-layout>
    <x-slot:title>{{ $creator->name }} - Trassic</x-slot:title>

    <div class="w-full bg-white font-sans overflow-x-hidden selection:bg-[#ccff00] selection:text-black bg-grid-pattern min-h-screen">
        {{-- BREADCRUMB NAV --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-4 pb-2">
            <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-gray-500">
                <a href="{{ route('explore') }}" class="hover:text-[#254bfe] transition-colors">Explore</a> 
                <span class="mx-1">/</span> 
                <a href="{{ route('creators') }}" class="hover:text-[#254bfe] transition-colors">Creators</a> 
                <span class="mx-1">/</span> 
                <span class="text-[#254bfe] font-bold">{{ $creator->name }}</span>
            </p>
        </div>

        {{-- KOMPONEN LIVEWIRE --}}
        <livewire:creator-show :creator="$creator" />
    </div>
</x-app-layout>