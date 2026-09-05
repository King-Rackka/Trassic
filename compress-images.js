const sharp = require('sharp');
const fs = require('fs');
const path = require('path');

const inputDir = './public/images';
const outputDir = './public/images-compressed';

if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir, { recursive: true });
}

const files = fs.readdirSync(inputDir).filter(f => f.endsWith('.png'));

async function compressAll() {
    for (const file of files) {
        const inputPath = path.join(inputDir, file);
        const outputPath = path.join(outputDir, file);

        const metadata = await sharp(inputPath).metadata();
        const originalSize = fs.statSync(inputPath).size;

        let pipeline = sharp(inputPath);
        if (metadata.width > 1600) {
            pipeline = pipeline.resize({ width: 1600, withoutEnlargement: true });
        }

        await pipeline
            .png({ quality: 85, compressionLevel: 9, palette: true })
            .toFile(outputPath);

        const newSize = fs.statSync(outputPath).size;
        const reduction = (((originalSize - newSize) / originalSize) * 100).toFixed(1);

        console.log(`${file}: ${(originalSize/1024).toFixed(0)}KB → ${(newSize/1024).toFixed(0)}KB (-${reduction}%)`);
    }
    console.log('\nSelesai! Cek folder:', outputDir);
}

compressAll();