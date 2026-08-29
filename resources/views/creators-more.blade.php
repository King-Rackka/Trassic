<x-app-layout>
    <x-slot:title>Kreator Lainnya - Trassic</x-slot:title>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-sm text-gray-500 mb-4">
                <a href="{{ route('creators') }}" class="hover:underline">Creators</a> / Kreator lainnya
            </p>
            <h1 class="font-display text-3xl text-[#254bfe] uppercase mb-8">Jelajahi kreator lainnya</h1>
            <livewire:creators-more />
        </div>
    </div>
</x-app-layout>