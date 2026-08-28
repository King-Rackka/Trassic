import React from 'react';
import ReactDOM from 'react-dom/client';
import PixelSwap from '../components/PixelSwap/PixelSwap';
import '../components/PixelSwap/PixelSwap.css';

function initPixelSwap() {
    const container = document.getElementById('pixelswap-banner-root');
    if (!container) return;

    const trashImg = container.getAttribute('data-trash-img');
    const tapeImg = container.getAttribute('data-tape-img');

    // Layer 1: Hanya Foto Sampah
    const firstContent = (
        <div className="w-full h-full relative flex items-center justify-center overflow-hidden">
            <img 
                src={trashImg} 
                alt="Trash Blue Banner" 
                className="w-full h-full object-cover select-none pointer-events-none" 
            />
        </div>
    );

    // Layer 2: Foto Sampah + Pita Group 24
    const secondContent = (
        <div className="w-full h-full relative flex items-center justify-center overflow-hidden">
            <img 
                src={trashImg} 
                alt="Trash Blue Banner" 
                className="w-full h-full object-cover select-none pointer-events-none" 
            />
            <div className="absolute inset-0 flex items-center justify-center pointer-events-none select-none">
                <img 
                    src={tapeImg} 
                    alt="Biasakan Rajin Buang Sampah" 
                    className="w-[125%] sm:w-[110%] lg:w-[102%] max-w-none h-auto object-contain drop-shadow-[0_12px_24px_rgba(0,0,0,0.45)]" 
                />
            </div>
        </div>
    );

    ReactDOM.createRoot(container).render(
        <React.StrictMode>
            <PixelSwap
                firstContent={firstContent}
                secondContent={secondContent}
                trigger="hover"
                aspectRatio="auto"
                className="w-full h-full"
                style={{ width: '100%', height: '100%' }}
                pixelSize={48}
                duration={900}
                pixelDuration={350}
                pattern="random"
                pixelScale={0.2}
                pixelRadius={0}
            />
        </React.StrictMode>
    );
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPixelSwap);
} else {
    initPixelSwap();
}