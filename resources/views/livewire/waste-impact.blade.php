<div class="w-full bg-grid-pattern min-h-screen py-6 sm:py-8 font-sans selection:bg-[#D9FC28] selection:text-[#2F3AFF]">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 lg:px-[40px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER + LIVE DATA BADGE --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 mb-12">
            <div class="max-w-xl">
                <span class="inline-flex items-center gap-2 bg-[#D9FC28] border-2 border-[#2F3AFF] text-[#2F3AFF] text-xs font-bold uppercase px-3 py-1 mb-4 shadow-[3px_3px_0px_#FC00BB]">
                    <span class="w-2 h-2 rounded-full bg-[#FC00BB] animate-pulse"></span>
                    Live data
                </span>
                <p class="text-[#2F3AFF] text-sm sm:text-base">
                    Mendokumentasikan transformasi material buangan menjadi sumber daya bernilai.
                    Setiap metrik merepresentasikan intervensi fisik dalam aliran limbah.
                </p>
            </div>

            {{-- Card Total Sampah --}}
            <div class="bg-[#F8F8F8] border-2 border-[#FC00BB] shadow-[6px_6px_0px_#2F3AFF] p-6 w-full sm:w-80 shrink-0 text-left">
                <p class="text-sm text-[#2F3AFF] font-semibold mb-1 text-left">Total sampah digunakan</p>
                <p class="font-display text-4xl sm:text-5xl text-[#2F3AFF] text-left">
                    {{ number_format($totalWasteKg, 1) }} kg
                </p>
            </div>
        </div>

        {{-- DISCLAIMER TRANSPARANSI --}}
        <div class="bg-white border-2 border-[#2F3AFF] p-4 mb-10 text-xs sm:text-sm text-[#2F3AFF]">
            <strong>Transparansi Data:</strong> Angka yang ditampilkan berdasarkan data yang dilaporkan sendiri
            oleh kreator saat mengunggah karya, dan hanya mencakup karya yang sudah dipublikasikan di TRASSIC.
            Angka ini merepresentasikan aktivitas yang tercatat di platform, bukan hasil verifikasi independen
            atas dampak lingkungan sebenarnya.
        </div>

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-16">
            <div class="bg-[#FC00BB] border-2 border-[#2F3AFF] shadow-[6px_6px_0px_#2F3AFF] p-6">
                <p class="text-[#D9FC28] font-bold text-sm mb-1">Published works</p>
                <p class="font-display text-4xl text-[#D9FC28]">{{ number_format($publishedWorksCount) }} posts</p>
            </div>
            <div class="bg-[#FC00BB] border-2 border-[#2F3AFF] shadow-[6px_6px_0px_#2F3AFF] p-6">
                <p class="text-[#D9FC28] font-bold text-sm mb-1">Active creators</p>
                <p class="font-display text-4xl text-[#D9FC28]">{{ number_format($activeCreatorsCount) }} creators</p>
            </div>
        </div>

        {{-- SECTION 2: WASTE DICTIONARY --}}
        <h2 class="font-display text-3xl sm:text-4xl text-[#2F3AFF] text-center mb-16">Impact</h2>

        @php
            $wasteDictionary = [
                [
                    'title' => 'Sampah Plastik',
                    'description' => 'Sampah plastik seperti botol, kantong, dan kemasan yang sulit terurai secara alami, namun bisa diolah menjadi berbagai produk kerajinan bernilai jual tinggi.',
                    'image' => 'images/sampah-plastik.png',
                ],
                [
                    'title' => 'Sampah Tekstil',
                    'description' => 'Sisa kain, pakaian bekas, dan potongan konveksi yang bisa dianyam atau dijahit ulang menjadi produk fashion dan aksesoris baru.',
                    'image' => 'images/sampah-tekstil.png',
                ],
                [
                    'title' => 'Sampah Kaca',
                    'description' => 'Botol dan pecahan kaca bekas yang dapat dipotong, dibentuk ulang, atau dijadikan elemen dekoratif seperti lampu hias.',
                    'image' => 'images/sampah-kaca.png',
                ],
            ];
        @endphp

        {{-- Menggunakan space-y-32 untuk memberi jarak antarkotak yang lega dan aman dari tumpukan --}}
        <div class="space-y-32 pt-8  mb-20 sm:mb-32">
        @foreach ($wasteDictionary as $item)
            <div class="relative">

                {{-- Box Kuning: ditambahkan pr-36 sm:pr-60 lg:pr-72 agar teks memiliki aman batas kanan dan tidak pernah menabrak box biru --}}
                <div class="bg-[#D9FC28] border-2 border-[#2F3AFF] rounded-tl-3xl shadow-[6px_6px_0px_#FC00BB] p-6 sm:p-8 pr-36 sm:pr-60 lg:pr-72">
                    <h3 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] mb-2">{{ $item['title'] }}</h3>
                    <p class="text-[#2F3AFF] text-sm sm:text-base leading-relaxed">{{ $item['description'] }}</p>
                </div>

                {{-- Box Biru: dipasang posisi vertikal terpusat (-translate-y-1/2) agar simetris mengambang di sebelah kanan --}}
                <div class="absolute top-1/2 -translate-y-1/2 -right-4 sm:-right-8 lg:-right-10 w-36 sm:w-52 lg:w-60 aspect-square shrink-0 bg-[#2F3AFF] border-2 border-[#FC00BB] shadow-[6px_6px_0px_#FC00BB] rotate-6 flex items-center justify-center p-3 sm:p-5 z-10">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-contain"
                        onerror="this.style.display='none'">
                </div>

            </div>
        @endforeach
    </div>

            {{-- Contoh dengan jarak bawaan Tailwind  --}}
        <div class="bg-[#F8F8F8] border-2 border-[#FC00BB] shadow-[8px_8px_0px_#2F3AFF] p-8 sm:p-12 mt-12 sm:mt-20 mb-20 sm:mb-32">
            {{-- 1. JUDUL (FONT LEBIH BESAR) --}}
            <h2 class="font-display text-4xl sm:text-5xl text-[#2F3AFF] text-center mb-10 sm:mb-12 tracking-wide ">
                Material yang terpakai
            </h2>

            <div class="space-y-6 sm:space-y-8">
                @forelse ($topMaterials as $i => $material)
                    {{-- 2. BARIS ITEM: GAP JARAK DIATUR DI SINI (gap-[12px]) --}}
                    <div class="flex items-center gap-[24px]">
                        
                        {{-- 3. NOMOR (#1, #2, ...) --}}
                        <span class="font-display text-4xl sm:text-6xl text-[#2F3AFF] w-14 sm:w-16 shrink-0 text-left leading-none">
                            #{{ $i + 1 }}
                        </span>

                        <div class="flex-1 min-w-0">
                            {{-- 4. LABEL MATERIAL & PERSENTASE --}}
                            <div class="flex justify-between items-baseline mb-1.5 sm:mb-2">
                                <span class="font-sans font-bold text-2xl sm:text-xl text-[#2F3AFF] truncate">
                                    {{ $material->material }}
                                </span>
                                <span class="font-sans font-bold text-xs sm:text-sm text-[#2F3AFF] shrink-0 ml-2">
                                    {{ $material->percentage }}%
                                </span>
                            </div>

                            {{-- 5. PROGRESS BAR (KANAN-ATAS & KIRI-BAWAH LANCIP) --}}
                            <div class="w-full h-3.5 sm:h-4 bg-white border-2 border-[#2F3AFF] rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none overflow-hidden">
                                <div class="h-full bg-[#2F3AFF] transition-all duration-500" 
                                    style="width: {{ $material->percentage }}%"></div>
                            </div>
                        </div>

                    </div>
                @empty
                    <p class="text-center text-gray-400 font-sans text-sm py-4">Belum ada data material.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
</div>