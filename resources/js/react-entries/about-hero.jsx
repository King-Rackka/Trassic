import { createRoot } from 'react-dom/client';
import TextType from '../components/TextType';

function mount(id, extraClassName) {
    const el = document.getElementById(id);
    if (!el) return;

    createRoot(el).render(
        <TextType
            texts={["WASTE\nISN'T THE\nEND OF\nTHE STORY"]}
            typingSpeed={55}
            pauseDuration={99999999} // teks statis setelah selesai diketik, tidak dihapus lagi
            loop={false}
            showCursor
            cursorCharacter="_"
            cursorBlinkDuration={0.6}
            className={extraClassName}
        />
    );
}

document.addEventListener('DOMContentLoaded', () => {
    mount('about-hero-typetext-left');
    mount('about-hero-typetext-right');
});