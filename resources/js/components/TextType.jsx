import { useEffect, useRef, useState } from 'react';

/**
 * TextType — efek animasi mengetik/menghapus teks bergantian.
 *
 * Props:
 * - text / texts : string | string[]  (array teks yang dicycle bergantian)
 * - typingSpeed          : ms per karakter saat mengetik (default 75)
 * - deletingSpeed         : ms per karakter saat menghapus (default 50)
 * - pauseDuration         : jeda (ms) setelah selesai mengetik sebelum mulai menghapus (default 1500)
 * - loop                  : ulang dari awal setelah teks terakhir selesai (default true)
 * - showCursor            : tampilkan cursor berkedip (default true)
 * - cursorCharacter       : karakter cursor (default "|")
 * - cursorBlinkDuration   : durasi kedip cursor dalam detik (default 0.5)
 * - variableSpeedEnabled  : kecepatan ketik acak per karakter (default false)
 * - variableSpeedMin/Max  : rentang ms kalau variableSpeedEnabled true
 * - className             : class tambahan untuk wrapper <span>
 */
export default function TextType({
    text,
    texts,
    typingSpeed = 75,
    deletingSpeed = 50,
    pauseDuration = 1500,
    loop = true,
    showCursor = true,
    cursorCharacter = '|',
    cursorBlinkDuration = 0.5,
    variableSpeedEnabled = false,
    variableSpeedMin = 60,
    variableSpeedMax = 120,
    className = '',
}) {
    const items = (texts && texts.length ? texts : Array.isArray(text) ? text : [text]).filter(Boolean);

    const [textIndex, setTextIndex] = useState(0);
    const [displayed, setDisplayed] = useState('');
    const [phase, setPhase] = useState('typing'); // typing | pausing | deleting
    const timeoutRef = useRef(null);

    useEffect(() => {
        const current = items[textIndex] ?? '';

        const nextDelay = () => {
            if (!variableSpeedEnabled) return phase === 'deleting' ? deletingSpeed : typingSpeed;
            return Math.floor(Math.random() * (variableSpeedMax - variableSpeedMin + 1)) + variableSpeedMin;
        };

        if (phase === 'typing') {
            if (displayed.length < current.length) {
                timeoutRef.current = setTimeout(() => {
                    setDisplayed(current.slice(0, displayed.length + 1));
                }, nextDelay());
            } else {
                timeoutRef.current = setTimeout(() => setPhase('pausing'), pauseDuration);
            }
        } else if (phase === 'pausing') {
            const isLastItem = textIndex === items.length - 1;
            if (!loop && isLastItem) return; // berhenti, tidak menghapus
            timeoutRef.current = setTimeout(() => setPhase('deleting'), 0);
        } else if (phase === 'deleting') {
            if (displayed.length > 0) {
                timeoutRef.current = setTimeout(() => {
                    setDisplayed(current.slice(0, displayed.length - 1));
                }, nextDelay());
            } else {
                setTextIndex((i) => (i + 1) % items.length);
                setPhase('typing');
            }
        }

        return () => clearTimeout(timeoutRef.current);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [displayed, phase, textIndex]);

    return (
        <span className={className} style={{ whiteSpace: 'pre-line' }}>
            {displayed}
            {showCursor && (
                <span
                    style={{
                        display: 'inline-block',
                        marginLeft: '2px',
                        animation: `text-type-blink ${cursorBlinkDuration}s step-end infinite`,
                    }}
                >
                    {cursorCharacter}
                </span>
            )}
            <style>{`
                @keyframes text-type-blink {
                    0%, 100% { opacity: 1; }
                    50% { opacity: 0; }
                }
            `}</style>
        </span>
    );
}