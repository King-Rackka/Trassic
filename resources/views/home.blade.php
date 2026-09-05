<x-app-layout>
    <x-slot:title>Beranda - Trassic</x-slot:title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>

    <style>
        @keyframes trashFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(2deg); }
        }
        .animate-trash-float {
            animation: trashFloat 3.5s ease-in-out infinite;
        }

        @keyframes bounceBack {
            0% { transform: scale(1.3) translate(0, 0); }
            20% { transform: scale(0.8) translate(-20px, 15px) rotate(-15deg); }
            40% { transform: scale(1.15) translate(15px, -10px) rotate(10deg); }
            60% { transform: scale(0.9) translate(-8px, 5px); }
            100% { transform: scale(1) translate(0, 0) rotate(0deg); }
        }
        .animate-bounce-back {
            animation: bounceBack 0.65s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }

        @keyframes marqueeLeftToRight {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0%); }
        }
        @keyframes marqueeRightToLeft {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }

        .animate-marquee-l2r {
            display: flex;
            width: max-content;
            animation: marqueeLeftToRight 10s linear infinite;
        }

        .animate-marquee-r2l {
            display: flex;
            width: max-content;
            animation: marqueeRightToLeft 10s linear infinite;
        }
    </style>

    <div class="w-full flex flex-col bg-white font-sans overflow-x-hidden selection:bg-[#D9FC28] selection:text-[#2F3AFF]" x-data="landingGame()">

        {{-- TOAST NOTIFICATION FLOATING --}}
        <div class="fixed top-16 sm:top-20 right-4 sm:right-6 z-50 flex flex-col gap-2 pointer-events-none max-w-[90vw]">
            <template x-for="(toast, index) in toasts" :key="index">
                <div class="pointer-events-auto px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl border-2 border-black font-display uppercase tracking-wider text-xs sm:text-sm shadow-[4px_4px_0px_rgba(0,0,0,1)] transition-all transform duration-300"
                     :class="{
                         'bg-[#D9FC28] text-[#2F3AFF]': toast.type === 'success',
                         'bg-[#FC00BB] text-white': toast.type === 'error',
                         'bg-[#2F3AFF] text-white': toast.type === 'info'
                     }"
                     x-text="toast.message">
                </div>
            </template>
        </div>

        {{-- Section 1: Hero --}}
        <section class="w-full min-h-[calc(100vh-62px)] flex flex-col lg:flex-row bg-grid-pattern relative overflow-hidden py-8 sm:py-16 px-6 sm:px-12 lg:px-[80px]">
            {{-- KIRI: Visual Kaleng --}}
            <div class="w-full lg:w-[50%] flex items-center justify-center p-4 sm:p-7 relative">
                <div class="relative w-[280px] xs:w-[320px] sm:w-[480px] h-[280px] xs:h-[320px] sm:h-[480px] flex items-center justify-center my-4">
                    <img src="{{ asset('images/vector/vector_petir_1.png') }}" alt="Vector Petir 1" class="absolute w-[115%] h-[115%] object-contain z-0 pointer-events-none transform -rotate-12">
                    <img src="{{ asset('images/vector/vector_petir_2.png') }}" alt="Vector Petir 2" class="absolute w-[120%] h-[120%] object-contain z-0 pointer-events-none transform rotate-45">
                    <img src="{{ asset('images/vector/Vector_Landingpage_1.png') }}" alt="Vector Circular" class="absolute inset-0 w-full h-full object-contain animate-[spin_16s_linear_infinite] z-10 pointer-events-none">
                    <img src="{{ asset('images/recycle-can.png') }}" alt="Recycle Can" class="w-[85%] sm:w-[90%] h-[85%] sm:h-[90%] object-contain drop-shadow-2xl z-20 animate-float -scale-x-100">
                </div>
            </div>

            <div class="w-full lg:w-[50%] flex items-center justify-center p-6 sm:p-12">
                <div class="max-w-lg space-y-6 text-center lg:text-left">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display text-[#2F3AFF] tracking-wide" style="line-height: 1.35 !important;">
                        Zaman gini masih buang sampah sembarangan?
                    </h1>
                    <p class="text-gray-700 text-sm sm:text-base font-medium leading-relaxed">
                        Kelola dan daur ulang sampahmu bersama <strong class="text-black font-bold">Trassic</strong>. Ubah kebiasaan lama menjadi langkah nyata untuk lingkungan yang lebih bersih.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('register') }}"
                           class="inline-block bg-[#D9FC28] text-[#2F3AFF] font-display text-base sm:text-xl px-6 sm:px-8 py-3 sm:py-3.5 border-2 border-black hover:bg-[#cbf21d] transition uppercase shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                            Mulai Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 2: Mini Game --}}
        <section class="w-full flex flex-col items-center justify-center py-8 sm:py-20 px-6 sm:px-12 lg:px-[80px] bg-grid-pattern relative overflow-hidden"
                 @pointermove.window="onPointerMove($event)"
                 @pointerup.window="onPointerUp($event)">
            
            <h2 class="text-2xl sm:text-5xl font-display text-[#2F3AFF] tracking-normal text-center mb-4 sm:mb-10 z-20 px-4">
                Latihan membuang sampah pada tempat yang sesuai
            </h2>

            <div x-ref="gameArea" class="w-full max-w-5xl h-[380px] sm:h-[620px] relative flex items-center justify-center select-none">
                <img src="{{ asset('images/vector/Group 20.png') }}" alt="Background Vector Trash" class="absolute w-[280px] sm:w-[580px] h-auto object-contain z-0 pointer-events-none drop-shadow-md">

                <div class="relative w-[210px] sm:w-[610px] h-[220px] sm:h-[420px] z-10 flex items-center justify-center">
                    <div data-bin="b3" class="absolute top-8 sm:top-2 left-1/2 -translate-x-1/2 w-28 sm:w-80 z-10 transition-transform duration-200 hover:scale-110 active:scale-105 cursor-pointer">
                        <img src="{{ asset('images/tempat-sampah-red.png') }}" alt="Tong B3" class="w-full h-auto object-contain drop-shadow-xl pointer-events-none">
                    </div>
                    <div data-bin="organik" class="absolute bottom-8 sm:bottom-2 left-4 sm:left-6 w-28 sm:w-80 z-20 -rotate-6 transition-transform duration-200 hover:scale-110 hover:-rotate-3 active:scale-105 cursor-pointer">
                        <img src="{{ asset('images/tempat-sampah-green.png') }}" alt="Tong Organik" class="w-full h-auto object-contain drop-shadow-2xl pointer-events-none">
                    </div>
                    <div data-bin="anorganik" class="absolute bottom-8 sm:bottom-2 right-4 sm:right-6 w-28 sm:w-80 z-20 rotate-6 transition-transform duration-200 hover:scale-110 hover:rotate-3 active:scale-105 cursor-pointer">
                        <img src="{{ asset('images/tempat-sampah-orange.png') }}" alt="Tong Anorganik" class="w-full h-auto object-contain drop-shadow-2xl pointer-events-none">
                    </div>
                </div>

                <template x-for="(item, index) in trashItems" :key="item.id">
                    <div x-show="!item.inBin"
                         @pointerdown="startDrag($event, index)"
                         :class="[
                             item.dragging ? '' : item.defaultClass,
                             !item.inBin && !item.dragging && !item.bouncing ? 'animate-trash-float' : '',
                             item.bouncing ? 'animate-bounce-back' : '',
                             item.dragging ? 'z-50 scale-125 cursor-grabbing' : '',
                             !item.inBin && !item.dragging ? 'z-30 cursor-grab hover:scale-110' : ''
                         ]"
                         :style="getItemStyle(item)"
                         class="absolute touch-none transition-transform">
                        <img :src="item.image" :alt="item.name" class="w-10 sm:w-28 h-auto object-contain drop-shadow-md pointer-events-none">
                    </div>
                </template>
            </div>

            <button x-show="allCompleted"
                    @click="resetGame()"
                    class="mt-4 bg-[#D9FC28] text-[#2F3AFF] font-display text-lg sm:text-xl px-6 py-2.5 border-2 border-black hover:bg-[#cbf21d] transition uppercase shadow-[4px_4px_0px_rgba(0,0,0,1)] z-20 cursor-pointer">
                Ulangi Latihan 🔄
            </button>
        </section>

        {{-- Section 3: Physics Matter.js (Full width, nempel ke layar tanpa gap horizontal) --}}
        <section class="w-full flex flex-col items-center justify-center py-6 sm:py-12 px-0 bg-grid-pattern relative overflow-hidden">
            <h2 class="text-2xl sm:text-5xl font-display text-[#2F3AFF] tracking-normal text-center mb-4 sm:mb-8 z-20 px-6 sm:px-12 lg:px-[80px]">
                Kenapa harus menggunakan trassic?
            </h2>

            <div class="w-full h-[250px] sm:h-[480px] relative flex items-center justify-center">
                <img src="{{ asset('images/vector/Vector_Landingpage_2.png') }}" alt="Vector Left" class="absolute top-1/2 -left-0 -translate-y-1/2 w-[55px] sm:w-auto h-[100%] sm:h-[140%] object-contain pointer-events-none z-10 -scale-x-100">
                <img src="{{ asset('images/vector/Vector_Landingpage_2.png') }}" alt="Vector Right" class="absolute top-1/2 -right-0 -translate-y-1/2 w-[55px] sm:w-auto h-[100%] sm:h-[140%] object-contain pointer-events-none z-10">

                <div id="physics-container" class="w-full h-full relative border-y-2 border-[#2F3AFF] overflow-hidden z-20" style="touch-action: pan-y;"></div>
            </div>

            <p class="text-xs sm:text-sm font-bold text-[#2F3AFF] mt-3 uppercase tracking-wider text-center px-6">
                Coba tarik, geser, atau lempar kapsul di atas!
            </p>
        </section>

        {{-- Section 4: Marquee Banners & Vector Petir (Direstrukturisasi agar petir tidak raksasa saat zoom-out) --}}
        <section class="w-full flex flex-col items-center justify-center bg-grid-pattern relative overflow-hidden py-6 sm:py-16">
            
            {{-- VECTOR PETIR ATAS: Menggunakan w-full max-w-[1440px] object-cover agar skalanya terkontrol & tidak ikut membesar secara berlebihan saat zoom out --}}
            <div class="w-full flex justify-center -mb-[50px] sm:-mb-[90px] lg:-mb-[130px] z-10 pointer-events-none select-none px-0">
                <img src="{{ asset('images/vector/Vector.png') }}" alt="Vector Top" class="w-full max-w-[1440px] h-auto object-cover scale-[1.03] translate-y-[30px] sm:translate-y-[40px]">
            </div>

            <div class="w-full relative flex items-center justify-center border-y-4 sm:border-y-8 border-[#D9FC28] z-20 overflow-hidden bg-white h-[260px] sm:h-[480px] lg:h-[600px]">
                <img src="{{ asset('images/image_27.png') }}" alt="Sampah Daur Ulang" class="w-full h-full object-cover">

                <div class="group absolute w-[140%] sm:w-[130%] h-16 sm:h-28 lg:h-32 transform -rotate-[8deg] bg-[#FC00BB] flex items-center overflow-hidden shadow-2xl origin-center cursor-pointer bg-[url('{{ asset('images/garis-pink.png') }}')] bg-cover bg-center">                
                    <div class="animate-marquee-l2r group-hover:[animation-play-state:paused] whitespace-nowrap flex items-center">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="flex items-center font-display text-2xl sm:text-5xl lg:text-7xl uppercase tracking-wider mx-3 sm:mx-6">
                                <span class="text-[#2F3AFF] font-extrabold mr-2">!</span>
                                <span class="text-[#D9FC28]">BIASAKAN RAJIN BUANG SAMPAH</span>
                                <span class="text-[#2F3AFF] font-extrabold ml-2 mr-4">!</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="group absolute w-[140%] sm:w-[130%] h-16 sm:h-28 lg:h-32 transform rotate-[6deg] bg-[#D9FC28] flex items-center overflow-hidden shadow-2xl origin-center cursor-pointer bg-[url('{{ asset('images/garis-kuning.png') }}')] bg-cover bg-center">
                    <div class="animate-marquee-r2l group-hover:[animation-play-state:paused] whitespace-nowrap flex items-center">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="flex items-center font-display text-2xl sm:text-5xl lg:text-7xl uppercase tracking-wider mx-3 sm:mx-6">
                                <span class="text-[#FC00BB] font-extrabold mr-2">!</span>
                                <span class="text-[#2F3AFF]">BIASAKAN RAJIN BUANG SAMPAH</span>
                                <span class="text-[#FC00BB] font-extrabold ml-2 mr-4">!</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- VECTOR PETIR BAWAH: Dibatasi max-w-[1440px] object-cover agar tidak melebar/membesar berlebihan --}}
            <div class="w-full flex justify-center -mt-[50px] sm:-mt-[90px] lg:-mt-[130px] z-10 pointer-events-none select-none px-0">
                <img src="{{ asset('images/vector/Vector (1).png') }}" alt="Vector Bottom" class="w-full max-w-[1440px] h-auto object-cover scale-[1.03] -translate-y-[30px] sm:-translate-y-[40px]">
            </div>

        </section>   

        {{-- Section 5: CTA / Karya (Dengan gap kiri kanan konsisten px-[80px]) --}}
        <section class="w-full my-10 sm:my-16 px-6 sm:px-12 lg:px-[80px]">
            <div class="w-full bg-[#D9FC28] rounded-2xl sm:rounded-[32px] p-6 sm:p-10 lg:p-12 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="shrink-0 text-left">
                    <h2 class="font-display text-3xl sm:text-5xl lg:text-6xl text-[#2F3AFF] leading-tight tracking-normal">
                        Mulai tambah<br>karyamu disini!
                    </h2>
                </div>

                <div class="flex-1 text-center px-4 hidden md:block">
                    <p class="font-sans text-xs sm:text-sm lg:text-base font-bold text-[#2F3AFF] leading-snug">
                        NICE Recycle<br>
                        Gallery Art Here
                    </p>
                </div>

                <div class="shrink-0 flex items-center gap-4">
                    <p class="font-sans text-xs font-bold text-[#2F3AFF] leading-snug md:hidden text-right">
                        NICE Recycle<br>
                        Gallery Art Here
                    </p>

                    @auth
                        <a href="{{ route('works.create') }}" 
                        class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 rounded-xl sm:rounded-2xl border-2 sm:border-3 border-[#2F3AFF] flex items-center justify-center text-[#D9FC28] bg-[#FC00BB] hover:bg-[#2F3AFF] hover:text-white transition-all duration-200 cursor-pointer">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 fill-none stroke-current" stroke-width="2.5" viewBox="0 0 24 24">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </a>
                    @else
                        <button type="button" 
                                @click="$dispatch('show-login-prompt')" 
                                class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 rounded-xl sm:rounded-2xl border-2 sm:border-3 border-[#2F3AFF] flex items-center justify-center text-[#2F3AFF] hover:bg-[#2F3AFF] hover:text-white transition-all duration-200 cursor-pointer">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 fill-none stroke-current" stroke-width="2.5" viewBox="0 0 24 24">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </button>
                    @endauth
                </div>
            </div>
        </section>

    </div>

    {{-- SCRIPT GAME & MATTER.JS PHYSICS --}}
    <script>
    function landingGame() {
        return {
            toasts: [],
            activeDragIndex: null,
            
            trashItems: [
                { id: 0, name: 'Botol Plastik', category: 'anorganik', image: "{{ asset('images/sampah-botol.png') }}", defaultClass: 'top-2 sm:top-10 left-2 sm:left-12', inBin: false, binCategory: null, dragging: false, bouncing: false, x: null, y: null },
                { id: 1, name: 'Limbah Jaring', category: 'b3', image: "{{ asset('images/sampah-jaring.png') }}", defaultClass: 'top-2 sm:top-10 right-2 sm:right-12', inBin: false, binCategory: null, dragging: false, bouncing: false, x: null, y: null },
                { id: 2, name: 'Kertas Remuk', category: 'anorganik', image: "{{ asset('images/sampah-kertas.png') }}", defaultClass: 'bottom-2 sm:bottom-10 left-2 sm:left-12', inBin: false, binCategory: null, dragging: false, bouncing: false, x: null, y: null },
                { id: 3, name: 'Sampah Organik', category: 'organik', image: "{{ asset('images/sampah-organik.png') }}", defaultClass: 'bottom-2 sm:bottom-10 right-2 sm:right-12', inBin: false, binCategory: null, dragging: false, bouncing: false, x: null, y: null }
            ],

            get allCompleted() {
                return this.trashItems.every(i => i.inBin && i.binCategory === i.category);
            },

            addToast(message, type = 'success') {
                this.toasts.push({ message, type });
                setTimeout(() => { this.toasts.shift(); }, 3000);
            },

            getItemStyle(item) {
                if (item.dragging) {
                    return `left: ${item.x}px; top: ${item.y}px; position: absolute;`;
                }
                return '';
            },

            startDrag(event, index) {
                this.activeDragIndex = index;
                const item = this.trashItems[index];
                item.dragging = true;
                item.inBin = false;
                item.bouncing = false;

                const rect = this.$refs.gameArea.getBoundingClientRect();
                item.x = event.clientX - rect.left - 20;
                item.y = event.clientY - rect.top - 20;
            },

            onPointerMove(event) {
                if (this.activeDragIndex === null) return;
                const item = this.trashItems[this.activeDragIndex];
                const rect = this.$refs.gameArea.getBoundingClientRect();

                item.x = event.clientX - rect.left - 20;
                item.y = event.clientY - rect.top - 20;
            },

            onPointerUp(event) {
                if (this.activeDragIndex === null) return;
                const index = this.activeDragIndex;
                const item = this.trashItems[index];
                item.dragging = false;
                this.activeDragIndex = null;

                const bins = this.$refs.gameArea.querySelectorAll('[data-bin]');
                let droppedBin = null;

                bins.forEach(bin => {
                    const binRect = bin.getBoundingClientRect();
                    if (
                        event.clientX >= binRect.left &&
                        event.clientX <= binRect.right &&
                        event.clientY >= binRect.top &&
                        event.clientY <= binRect.bottom
                    ) {
                        droppedBin = bin.getAttribute('data-bin');
                    }
                });

                if (droppedBin) {
                    if (item.category === droppedBin) {
                        item.inBin = true;
                        item.binCategory = droppedBin;
                        this.addToast(`Hebat! ${item.name} berhasil dibuang ke tempat ${droppedBin.toUpperCase()}`, 'success');

                        if (this.allCompleted) {
                            setTimeout(() => {
                                this.addToast('🎉 Luar biasa! Semua sampah berhasil dipilah dengan benar!', 'info');
                            }, 500);
                        }
                    } else {
                        item.bouncing = true;
                        item.inBin = false;
                        item.x = null;
                        item.y = null;
                        this.addToast(`Ups! ${item.name} kurang tepat jika dibuang ke tempat ${droppedBin.toUpperCase()}`, 'error');

                        setTimeout(() => { item.bouncing = false; }, 650);
                    }
                } else {
                    item.x = null;
                    item.y = null;
                }
            },

            resetGame() {
                this.trashItems.forEach(i => {
                    i.inBin = false;
                    i.dragging = false;
                    i.bouncing = false;
                    i.binCategory = null;
                    i.x = null;
                    i.y = null;
                });
                this.addToast('Game direset! Silakan coba lagi.', 'info');
            }
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('physics-container');
        if (!container) return;

        const width = container.clientWidth;
        const height = container.clientHeight;

        const Engine = Matter.Engine,
              Render = Matter.Render,
              Runner = Matter.Runner,
              Bodies = Matter.Bodies,
              Composite = Matter.Composite,
              Mouse = Matter.Mouse,
              MouseConstraint = Matter.MouseConstraint,
              Events = Matter.Events;

        const engine = Engine.create({
            positionIterations: 10,
            velocityIterations: 10
        });

        const render = Render.create({
            element: container,
            engine: engine,
            options: {
                width: width,
                height: height,
                wireframes: false,
                background: 'transparent'
            }
        });

        Render.run(render);
        const runner = Runner.create();
        Runner.run(runner, engine);

        const isMobile = window.innerWidth < 640;
        
        const wallOffset = isMobile ? 45 : 160;
        const wallThickness = 400;
        const invisibleStyle = { render: { visible: false } };

        const ground = Bodies.rectangle(width / 2, height + (wallThickness / 2), width * 2, wallThickness, { isStatic: true, ...invisibleStyle });
        const ceiling = Bodies.rectangle(width / 2, -(wallThickness / 2), width * 2, wallThickness, { isStatic: true, ...invisibleStyle });
        const leftWall = Bodies.rectangle(wallOffset - (wallThickness / 2), height / 2, wallThickness, height * 2, { isStatic: true, ...invisibleStyle });
        const rightWall = Bodies.rectangle((width - wallOffset) + (wallThickness / 2), height / 2, wallThickness, height * 2, { isStatic: true, ...invisibleStyle });

        Composite.add(engine.world, [ground, ceiling, leftWall, rightWall]);

        const rawBadges = [
            { text: 'Daur Ulang Mudah Together', bg: '#D9FC28', color: '#2F3AFF', baseWidth: isMobile ? 170 : 540 },
            { text: 'Eko-Kreatif Dengan Trassic', bg: '#FC00BB', color: '#D9FC28', baseWidth: isMobile ? 160 : 520 },
            { text: 'Ubah Sampah Jadi Karya', bg: '#D9FC28', color: '#2F3AFF', baseWidth: isMobile ? 145 : 470 },
            { text: 'Dukung Lingkungan Bersih', bg: '#FC00BB', color: '#D9FC28', baseWidth: isMobile ? 155 : 500 },
            { text: 'Komunitas Trassic Aktif', bg: '#D9FC28', color: '#2F3AFF', baseWidth: isMobile ? 145 : 480 },
            { text: 'Aksi Nyata Bumi Hijau', bg: '#FC00BB', color: '#D9FC28', baseWidth: isMobile ? 130 : 440 }
        ];

        const badgeBodies = [];

        rawBadges.forEach((data, index) => {
            const startX = (width / 2) + ((Math.random() - 0.5) * 15);
            const badgeHeight = isMobile ? 26 : 64;
            const startY = 10 + (index * (badgeHeight + 6));

            const body = Bodies.rectangle(startX, startY, data.baseWidth, badgeHeight, {
                chamfer: { radius: badgeHeight / 2 },
                restitution: 0.3,
                friction: 0.2,
                frictionAir: 0.015,
                render: {
                    fillStyle: data.bg,
                    strokeStyle: '#000000',
                    lineWidth: 0
                }
            });

            badgeBodies.push(body);
            Composite.add(engine.world, body);
        });

        const mouse = Mouse.create(render.canvas);
        render.canvas.removeEventListener("mousewheel", mouse.mousewheel);
        render.canvas.removeEventListener("DOMMouseScroll", mouse.mousewheel);

        const mouseConstraint = MouseConstraint.create(engine, {
            mouse: mouse,
            constraint: {
                stiffness: 0.08,
                damping: 0.05,
                render: { visible: false }
            }
        });
        Composite.add(engine.world, mouseConstraint);

        Events.on(engine, 'beforeUpdate', () => {
            if (mouseConstraint.body) {
                const body = mouseConstraint.body;
                const minX = wallOffset + 5;
                const maxX = width - wallOffset - 5;
                const minY = 5;
                const maxY = height - 5;

                if (body.position.x < minX || body.position.x > maxX || body.position.y < minY || body.position.y > maxY) {
                    mouseConstraint.constraint.bodyB = null;
                    mouseConstraint.constraint.pointB = null;
                }
            }
        });

        Events.on(render, 'afterRender', () => {
            const context = render.context;
            const bodies = Composite.allBodies(engine.world);

            const fontSize = isMobile ? '9px' : '32px';
            const fontWeight = isMobile ? '700' : '800';
            context.font = `${fontWeight} ${fontSize} "Helvetica", "Arial", sans-serif`;
            context.textAlign = 'center';
            context.textBaseline = 'middle';

            let textIndex = 0;
            bodies.forEach(body => {
                if (!body.isStatic && rawBadges[textIndex]) {
                    const data = rawBadges[textIndex];
                    context.save();
                    context.translate(body.position.x, body.position.y);
                    context.rotate(body.angle);
                    context.fillStyle = data.color;
                    context.fillText(data.text, 0, 0);
                    context.restore();
                    textIndex++;
                }
            });
        });
    });
    </script>
</x-app-layout>