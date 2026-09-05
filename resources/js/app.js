
import collapse from '@alpinejs/collapse';

import './react-entries/pixelswap-entry';

document.addEventListener('alpine:init', () => {
    Alpine.plugin(collapse);
});