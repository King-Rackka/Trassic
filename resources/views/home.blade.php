<x-app-layout>
    <x-slot:title>Beranda - Trassic</x-slot:title>

    {{-- Script Matter.js untuk Section 3 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>

    <style>
        @keyframes trashFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        .animate-trash-float {
            animation: trashFloat 3.5s ease-in-out infinite;
        }
        .animation-delay-1 { animation-delay: 0.7s; }
        .animation-delay-2 { animation-delay: 1.4s; }
        .animation-delay-3 { animation-delay: 2.1s; }
    </style>

    <div class="w-full flex flex-col bg-white font-sans overflow-x-hidden selection:bg-[#ccff00] selection:text-black" x-data="landingGame()">

        {{-- TOAST NOTIFICATION FLOATING --}}
        <div class="fixed top-16 sm:top-20 right-4 sm:right-6 z-50 flex flex-col gap-2 pointer-events-none max-w-[90vw]">
            <template x-for="(toast, index) in toasts" :key="index">
                <div class="pointer-events-auto px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl border-2 border-black font-display uppercase tracking-wider text-xs sm:text-sm shadow-[4px_4px_0px_rgba(0,0,0,1)] transition-all transform duration-300"
                     :class="{
                         'bg-[#ccff00] text-black': toast.type === 'success',
                         'bg-[#ff007a] text-white': toast.type === 'error',
                         'bg-[#254bfe] text-white': toast.type === 'info'
                     }"
                     x-text="toast.message">
                </div>
            </template>
        </div>

        {{-- ========================================== --}}
        {{-- SECTION 1: HERO SECTION --}}
        {{-- ========================================== --}}
        <section class="w-full min-h-[calc(100vh-62px)] flex flex-col lg:flex-row border-b-2 border-[#254bfe] bg-grid-pattern relative overflow-hidden">
            
            {{-- KIRI: Visual Kaleng + Lingkaran Muter + Aksen Petir --}}
            <div class="w-full lg:w-[59.3%] flex items-center justify-center p-4 sm:p-7 relative border-b-2 lg:border-b-0 lg:border-r-2 border-[#254bfe]">
                <div class="relative w-[280px] xs:w-[320px] sm:w-[480px] h-[280px] xs:h-[320px] sm:h-[480px] flex items-center justify-center my-4">
                    
                    {{-- Vector Petir 1 --}}
                    <img src="{{ asset('images/vector/vector_petir_1.png') }}" 
                         alt="Vector Petir 1" 
                         class="absolute w-[115%] h-[115%] object-contain z-0 pointer-events-none transform -rotate-12">

                    {{-- Vector Petir 2 --}}
                    <img src="{{ asset('images/vector/vector_petir_2.png') }}" 
                         alt="Vector Petir 2" 
                         class="absolute w-[120%] h-[120%] object-contain z-0 pointer-events-none transform rotate-45">

                    {{-- Vector Lingkaran Cat Biru Muter --}}
                    <img src="{{ asset('images/vector/Vector_Landingpage_1.png') }}" 
                         alt="Vector Circular" 
                         class="absolute inset-0 w-full h-full object-contain animate-[spin_16s_linear_infinite] z-10 pointer-events-none">

                    {{-- Visual Kaleng Floating --}}
                    <img src="{{ asset('images/recycle-can.png') }}" 
                         alt="Recycle Can" 
                         class="w-[85%] sm:w-[90%] h-[85%] sm:h-[90%] object-contain drop-shadow-2xl z-20 animate-float -scale-x-100">
                </div>
            </div>

            {{-- KANAN: Text Hero --}}
            <div class="w-full lg:w-[58%] flex items-center justify-center p-6 sm:p-16 bg-white/80 backdrop-blur-sm">
                <div class="max-w-xl space-y-4 sm:space-y-6 text-center lg:text-left">
                    <h1 class="text-3xl sm:text-6xl font-display text-[#254bfe] uppercase leading-tight tracking-normal">
                        Udah zaman gini masih buang sampah sembarangan?
                    </h1>
                    <p class="text-gray-700 text-sm sm:text-lg font-medium leading-relaxed">
                        Kelola dan daur ulang sampahmu bersama <strong class="text-black font-bold">Trassic</strong>. Ubah kebiasaan lama menjadi langkah nyata untuk lingkungan yang lebih bersih.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('register') }}" 
                           class="inline-block bg-[#ccff00] text-[#2f3cff] font-display text-lg sm:text-2xl px-6 sm:px-8 py-3 sm:py-3.5 rounded-2xl border-2 border-black hover:bg-lime-300 transition uppercase shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                            Mulai Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>


        {{-- ========================================== --}}
        {{-- SECTION 2: GAME MEMBUANG SAMPAH --}}
        {{-- ========================================== --}}
        <section class="w-full min-h-screen flex flex-col items-center justify-center py-8 sm:py-10 px-4 sm:px-8 border-b-2 border-[#254bfe] bg-grid-pattern relative overflow-hidden">
            
            <h2 class="text-2xl sm:text-5xl font-display text-[#254bfe] uppercase tracking-normal text-center mb-4 sm:mb-8 z-20">
                Latihan membuang sampah pada tempat yang sesuai
            </h2>

            <div class="w-full max-w-5xl h-[480px] sm:h-[620px] relative flex items-center justify-center">
                
                {{-- SVG DASHED LINES --}}
                <svg class="absolute inset-0 w-full h-full pointer-events-none z-10 hidden md:block" viewBox="0 0 1000 600" preserveAspectRatio="none">
                    <path d="M 120 180 Q 180 200, 260 230" fill="none" stroke="#254bfe" stroke-width="2.5" stroke-dasharray="8,8"/>
                    <path d="M 120 450 Q 180 430, 260 400" fill="none" stroke="#254bfe" stroke-width="2.5" stroke-dasharray="8,8"/>
                    <path d="M 880 180 Q 820 200, 740 230" fill="none" stroke="#254bfe" stroke-width="2.5" stroke-dasharray="8,8"/>
                    <path d="M 880 450 Q 820 430, 740 400" fill="none" stroke="#254bfe" stroke-width="2.5" stroke-dasharray="8,8"/>
                </svg>

                {{-- BACKGROUND VECTOR GROUP 20 --}}
                <img src="{{ asset('images/vector/Group 20.png') }}" 
                     alt="Background Vector Trash" 
                     class="absolute w-[300px] sm:w-[580px] h-auto object-contain z-0 pointer-events-none drop-shadow-md">

                {{-- 3 TEMPAT SAMPAH --}}
                <div class="relative w-[300px] sm:w-[610px] h-[280px] sm:h-[420px] z-10 flex items-center justify-center">
                    
                    {{-- TONG B3 --}}
                    <div @dragover.prevent 
                         @drop="onDrop($event, 'b3')"
                         class="absolute top-0 sm:top-2 left-1/2 -translate-x-1/2 w-40 sm:w-80 z-10 hover:scale-105 transition-transform cursor-pointer">
                        <img src="{{ asset('images/tempat-sampah-red.png') }}" alt="Tong B3" class="w-full h-auto object-contain drop-shadow-xl">
                    </div>

                    {{-- TONG ORGANIK --}}
                    <div @dragover.prevent 
                         @drop="onDrop($event, 'organik')"
                         class="absolute bottom-0 sm:bottom-2 left-0 sm:left-6 w-40 sm:w-80 z-20 hover:scale-105 transition-transform cursor-pointer -rotate-6">
                        <img src="{{ asset('images/tempat-sampah-green.png') }}" alt="Tong Organik" class="w-full h-auto object-contain drop-shadow-2xl">
                    </div>

                    {{-- TONG ANORGANIK --}}
                    <div @dragover.prevent 
                         @drop="onDrop($event, 'anorganik')"
                         class="absolute bottom-0 sm:bottom-2 right-0 sm:right-6 w-40 sm:w-80 z-20 hover:scale-105 transition-transform cursor-pointer rotate-6">
                        <img src="{{ asset('images/tempat-sampah-orange.png') }}" alt="Tong Anorganik" class="w-full h-auto object-contain drop-shadow-2xl">
                    </div>

                </div>

                {{-- 4 SAMPAH TANPA KOTAKAN --}}
                <div x-show="!trashItems[0].completed"
                     draggable="true" 
                     @dragstart="onDragStart($event, 0)"
                     class="absolute top-2 sm:top-10 left-1 sm:left-12 z-30 cursor-grab active:cursor-grabbing hover:scale-125 transition-transform animate-trash-float">
                    <img src="{{ asset('images/sampah-botol.png') }}" alt="Botol Plastik" class="w-14 sm:w-28 h-auto object-contain drop-shadow-md pointer-events-none">
                </div>

                <div x-show="!trashItems[1].completed"
                     draggable="true" 
                     @dragstart="onDragStart($event, 1)"
                     class="absolute top-2 sm:top-10 right-1 sm:right-12 z-30 cursor-grab active:cursor-grabbing hover:scale-125 transition-transform animate-trash-float animation-delay-1">
                    <img src="{{ asset('images/sampah-jaring.png') }}" alt="Limbah Jaring" class="w-14 sm:w-28 h-auto object-contain drop-shadow-md pointer-events-none rounded-xl">
                </div>

                <div x-show="!trashItems[2].completed"
                     draggable="true" 
                     @dragstart="onDragStart($event, 2)"
                     class="absolute bottom-2 sm:bottom-10 left-1 sm:left-12 z-30 cursor-grab active:cursor-grabbing hover:scale-125 transition-transform animate-trash-float animation-delay-2">
                    <img src="{{ asset('images/sampah-kertas.png') }}" alt="Kertas Remuk" class="w-14 sm:w-28 h-auto object-contain drop-shadow-md pointer-events-none rounded-xl">
                </div>

                <div x-show="!trashItems[3].completed"
                     draggable="true" 
                     @dragstart="onDragStart($event, 3)"
                     class="absolute bottom-2 sm:bottom-10 right-1 sm:right-12 z-30 cursor-grab active:cursor-grabbing hover:scale-125 transition-transform animate-trash-float animation-delay-3">
                    <img src="{{ asset('images/sampah-organik.png') }}" alt="Sampah Organik" class="w-14 sm:w-28 h-auto object-contain drop-shadow-md pointer-events-none rounded-xl">
                </div>

            </div>

            <button x-show="allCompleted" 
                    @click="resetGame()"
                    class="mt-4 bg-[#ccff00] text-[#2f3cff] font-display text-lg sm:text-xl px-6 py-2.5 rounded-2xl border-2 border-black hover:bg-lime-300 transition uppercase shadow-[4px_4px_0px_rgba(0,0,0,1)] z-20">
                Ulangi Latihan 🔄
            </button>
        </section>


        {{-- ========================================== --}}
        {{-- SECTION 3: PHYSICS BADGES (TETAP PERSIS DESKTOP ASLI DENGAN OPTIMASI MOBILE) --}}
        {{-- ========================================== --}}
        <section class="w-full min-h-screen flex flex-col items-center justify-center py-8 sm:py-12 px-2 sm:px-6 bg-grid-pattern relative overflow-hidden border-b-2 border-[#254bfe]">
            
            <h2 class="text-2xl sm:text-5xl font-display text-[#254bfe] uppercase tracking-normal text-center mb-6 sm:mb-8 z-20">
                Kenapa harus menggunakan trassic?
            </h2>

            {{-- VECTOR DESKTOP UTAMA (PERSIS ASLI) --}}
            <img src="{{ asset('images/vector/Vector_Landingpage_2.png') }}"
                 alt="Vector Left"
                 class="absolute top-1/2 -left-0 -translate-y-1/2 w-[90px] sm:w-auto h-[100%] max-h-[1000px] object-contain pointer-events-none z-10 -scale-x-100">

            <img src="{{ asset('images/vector/Vector_Landingpage_2.png') }}"
                 alt="Vector Right"
                 class="absolute top-1/2 -right-0 -translate-y-1/2 w-[90px] sm:w-auto h-[100%] max-h-[1000px] object-contain pointer-events-none z-10">

            {{-- CONTAINER CANVAS PHYSICS --}}
            <div id="physics-container" class="w-full h-[380px] sm:h-full relative border-y-2 border-[#254bfe] overflow-hidden z-20" style="touch-action: pan-y;">
            </div>

            <p class="text-[10px] sm:text-xs font-semibold text-gray-500 mt-4 uppercase tracking-wider text-center">
                💡 Coba tarik, geser, atau lempar kapsul di atas!
            </p>
        </section>

    </div>

    {{-- SCRIPT GAME & MATTER.JS PHYSICS --}}
    <script>
    function landingGame() {
        return {
            toasts: [],
            trashItems: [
                { id: 0, name: 'Botol Plastik', category: 'anorganik', completed: false },
                { id: 1, name: 'Limbah Jaring', category: 'b3', completed: false },
                { id: 2, name: 'Kertas Remuk', category: 'anorganik', completed: false },
                { id: 3, name: 'Sampah Organik', category: 'organik', completed: false },
            ],

            get allCompleted() {
                return this.trashItems.every(i => i.completed);
            },

            addToast(message, type = 'success') {
                this.toasts.push({ message, type });
                setTimeout(() => {
                    this.toasts.shift();
                }, 3000);
            },

            onDragStart(event, itemIndex) {
                event.dataTransfer.setData('text/plain', itemIndex);
            },

            onDrop(event, targetCategory) {
                const itemIndex = event.dataTransfer.getData('text/plain');
                if (itemIndex === '') return;

                const item = this.trashItems[itemIndex];

                if (item.category === targetCategory) {
                    item.completed = true;
                    this.addToast(`Hebat! ${item.name} berhasil dibuang ke tempat ${targetCategory.toUpperCase()}`, 'success');

                    if (this.allCompleted) {
                        setTimeout(() => {
                            this.addToast('🎉 Luar biasa! Semua sampah berhasil dipilah dengan benar!', 'info');
                        }, 500);
                    }
                } else {
                    this.addToast(`Ups! ${item.name} kurang tepat jika dibuang ke tempat ${targetCategory.toUpperCase()}`, 'error');
                }
            },

            resetGame() {
                this.trashItems.forEach(i => i.completed = false);
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

        // Deteksi Layar HP vs Desktop
        const isMobile = window.innerWidth < 640;
        const wallOffset = isMobile ? 70 : 160;
        const badgeScale = isMobile ? 0.65 : 1.0;
        const wallThickness = 400;
        const invisibleStyle = { render: { visible: false } };

        // Dinding Fisik
        const ground = Bodies.rectangle(width / 2, height + (wallThickness / 2), width * 2, wallThickness, { isStatic: true, ...invisibleStyle });
        const ceiling = Bodies.rectangle(width / 2, -(wallThickness / 2), width * 2, wallThickness, { isStatic: true, ...invisibleStyle });
        const leftWall = Bodies.rectangle(wallOffset - (wallThickness / 2), height / 2, wallThickness, height * 2, { isStatic: true, ...invisibleStyle });
        const rightWall = Bodies.rectangle((width - wallOffset) + (wallThickness / 2), height / 2, wallThickness, height * 2, { isStatic: true, ...invisibleStyle });

        Composite.add(engine.world, [ground, ceiling, leftWall, rightWall]);

        // Kapsul Teks (Proporsional di Desktop & Mobile)
        const rawBadges = [
            { text: 'Lorem ipsum dolor', bg: '#ccff00', color: '#254bfe', width: 200 * badgeScale },
            { text: 'Lorem ipsum dolor sit amet', bg: '#ff007a', color: '#ccff00', width: 260 * badgeScale },
            { text: 'Lorem ipsum dolor', bg: '#ccff00', color: '#254bfe', width: 190 * badgeScale },
            { text: 'Lorem ipsum dolor sit amet', bg: '#ff007a', color: '#ccff00', width: 270 * badgeScale },
            { text: 'Lorem ipsum dolor sit amet', bg: '#ccff00', color: '#254bfe', width: 260 * badgeScale },
            { text: 'Lorem ipsum dolor', bg: '#ff007a', color: '#ccff00', width: 210 * badgeScale }
        ];

        const badgeBodies = [];

        rawBadges.forEach((data, index) => {
            const startX = (width / 2) + ((Math.random() - 0.5) * 30);
            const startY = 30 + (index * (40 * badgeScale));
            const badgeHeight = 42 * badgeScale;

            const body = Bodies.rectangle(startX, startY, data.width, badgeHeight, {
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

        // Control Mouse & Touch + Scroll Fix
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

        // Release Mouse Jika Ditarik Paksa Keluar Batas
        Events.on(engine, 'beforeUpdate', () => {
            if (mouseConstraint.body) {
                const body = mouseConstraint.body;
                const minX = wallOffset + 15;
                const maxX = width - wallOffset - 15;
                const minY = 10;
                const maxY = height - 10;

                if (body.position.x < minX || body.position.x > maxX || body.position.y < minY || body.position.y > maxY) {
                    mouseConstraint.constraint.bodyB = null;
                    mouseConstraint.constraint.pointB = null;
                }
            }
        });

        // Render Teks Bolder
        Events.on(render, 'afterRender', () => {
            const context = render.context;
            const bodies = Composite.allBodies(engine.world);

            const fontSize = isMobile ? '10px' : '14px';
            context.font = `700 ${fontSize} "Inter", sans-serif`;
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