let cachedBaseImage = null;

export function generateTrassicCardTexture(knownAsText, joinDateText, isChecked, bgImageUrl) {
    return new Promise((resolve) => {
        const canvas = document.createElement('canvas');
        canvas.width = 600;
        canvas.height = 900;
        const ctx = canvas.getContext('2d');

        const drawContent = (img) => {
            try {
                // 🔴 DIHAPUS: gradient background yang sebelumnya ngefill seluruh canvas
                // duluan sebelum lanyard.png ditumpuk — ini yang bikin sudut-sudut
                // transparan badge (notch, corner membulat) keliatan ada "lahan" warna
                // gradient di baliknya. Sekarang canvas dibiarkan transparan dulu,
                // baru badge-nya digambar di atas — jadi area di luar badge tetap
                // transparan (nggak ada warna lain yang nembus).

                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                ctx.fillStyle = '#254bfe';
                ctx.font = '900 40px "Anton", sans-serif';
                ctx.textAlign = 'left';
                let rawName = (knownAsText && knownAsText.trim()) ? knownAsText.trim() : 'MAPLESTAR';
                if (rawName.length > 15) {
                    rawName = rawName.substring(0, 15);
                }
                ctx.fillText(rawName.toUpperCase(), 215, 665);

                ctx.fillStyle = '#254bfe';
                ctx.font = '900 40px "Anton", sans-serif';
                ctx.fillText(joinDateText || '25/08/2026', 215, 725);

                ctx.lineWidth = 3;
                ctx.strokeStyle = '#ffffff';
                ctx.fillStyle = isChecked ? '#ccff00' : 'rgba(0,0,0,0)';

                ctx.fillRect(175, 800, 26, 26);
                ctx.strokeRect(175, 800, 26, 26);

                if (isChecked) {
                    ctx.strokeStyle = '#254bfe';
                    ctx.lineWidth = 4;
                    ctx.beginPath();
                    ctx.moveTo(181, 813);
                    ctx.lineTo(188, 820);
                    ctx.lineTo(197, 806);
                    ctx.stroke();
                }

                ctx.fillStyle = '#ffffff';
                ctx.font = '600 12.5px "Inter", sans-serif';
                ctx.fillText("I confirm that I have read and accepted the Terms", 212, 812);
                ctx.fillText("and Conditions and Privacy Policy.", 212, 827);

                resolve(canvas.toDataURL('image/png'));
            } catch (err) {
                console.error("Error drawing canvas texture:", err);
                resolve(canvas.toDataURL('image/png'));
            }
        };

        if (cachedBaseImage) {
            drawContent(cachedBaseImage);
        } else {
            const img = new Image();
            img.crossOrigin = 'Anonymous';
            img.src = bgImageUrl;
            img.onload = () => {
                cachedBaseImage = img;
                drawContent(img);
            };
            img.onerror = (e) => {
                console.error("Gagal memuat gambar template", e);
                resolve(canvas.toDataURL('image/png'));
            };
        }
    });
}