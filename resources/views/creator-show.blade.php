<x-app-layout>
    <x-slot:title>{{ $creator->name }} - Trassic</x-slot:title>

    <div class="w-full bg-white font-sans overflow-x-hidden selection:bg-[#ccff00] selection:text-black">
        <livewire:creator-show :creator="$creator" />
    </div>
</x-app-layout>