import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import Lanyard from './Lanyard';
import { generateTrassicCardTexture } from './cardTextureGenerator';

function CreatorLanyard({ name, joinDate }) {
    const [cardTexUrl, setCardTexUrl] = useState('/images/lanyard.png');

    useEffect(() => {
        // Statis — generate sekali aja pas mount, isChecked selalu true
        // (creator ini emang udah anggota terverifikasi, bukan lagi ngisi form).
        generateTrassicCardTexture(name, joinDate, true, '/images/lanyard.png')
            .then(url => {
                if (url) setCardTexUrl(url);
            });
    }, [name, joinDate]);

    return (
        <div style={{ width: '100%', height: '100%' }}>
            <Lanyard
                position={[0, 0, 8.5]}
                gravity={[0, -40, 0]}
                frontImage={cardTexUrl}
                backImage={cardTexUrl}
                imageFit="cover"
                lanyardWidth={1.2}
            />
        </div>
    );
}

const container = document.getElementById('creator-lanyard-react-root');
if (container) {
    const name = container.dataset.name || 'MAPLESTAR';
    const joinDate = container.dataset.join || '25/08/2026';

    ReactDOM.createRoot(container).render(<CreatorLanyard name={name} joinDate={joinDate} />);
}