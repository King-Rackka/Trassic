import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import Lanyard from './Lanyard';
import { generateTrassicCardTexture } from './cardTextureGenerator';

function LanyardWrapper() {
    const [name, setName] = useState('');
    const [acceptedTerms, setAcceptedTerms] = useState(false);
    const [cardTexUrl, setCardTexUrl] = useState('/images/lanyard.png');

    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();
    const joinDate = `${dd}/${mm}/${yyyy}`;

    useEffect(() => {
        const handleAlpineInput = (e) => {
            if (e.detail.name !== undefined) setName(e.detail.name);
            if (e.detail.acceptedTerms !== undefined) setAcceptedTerms(e.detail.acceptedTerms);
        };

        window.addEventListener('lanyard-update', handleAlpineInput);
        return () => window.removeEventListener('lanyard-update', handleAlpineInput);
    }, []);

    useEffect(() => {
        generateTrassicCardTexture(name, joinDate, acceptedTerms, '/images/lanyard.png')
            .then(url => {
                if (url) setCardTexUrl(url);
            });
    }, [name, acceptedTerms]);

    const handleCardClick = () => {
        const nextState = !acceptedTerms;
        setAcceptedTerms(nextState);

        window.dispatchEvent(new CustomEvent('terms-toggled', {
            detail: { acceptedTerms: nextState }
        }));
    };

    return (
        <div style={{ width: '100%', height: '100%' }} onClick={handleCardClick}>
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

const container = document.getElementById('lanyard-react-root');
if (container) {
    ReactDOM.createRoot(container).render(<LanyardWrapper />);
}