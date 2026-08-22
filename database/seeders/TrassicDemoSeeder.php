<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CreatorProfile;
use App\Models\Work;
use App\Models\WasteDna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrassicDemoSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 1. Buat Users + Creator Profiles =====
        $creatorsData = [
            [
                'name' => 'Rani Mardiani',
                'email' => 'rani.mardiani@example.com',
                'creator_type' => 'umkm',
                'bio' => 'Menekuni teknik origami multilayer dari plastik sachet sejak 2020. Mengubah limbah "rosok" yang tak laku dijual jadi kerajinan bernilai tinggi.',
                'location' => 'Semarang, Jawa Tengah',
            ],
            [
                'name' => 'Amanda Prita',
                'email' => 'amanda.prita@example.com',
                'creator_type' => 'studio',
                'bio' => 'Bersama dua rekannya membangun studio furnitur dari tutup botol dan galon plastik HDPE bekas.',
                'location' => 'Sawangan, Depok',
            ],
            [
                'name' => 'Bank Sampah Melati',
                'email' => 'melati.banksampah@example.com',
                'creator_type' => 'community',
                'bio' => 'Komunitas warga yang mengolah sampah kemasan kopi, jas hujan plastik, dan botol kaca jadi produk kerajinan rumah tangga.',
                'location' => 'Duren Sawit, Jakarta Timur',
            ],
        ];

        $creators = [];
        foreach ($creatorsData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);

            $creators[] = CreatorProfile::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'bio' => $data['bio'],
                'creator_type' => $data['creator_type'],
                'location' => $data['location'],
                'social_links' => json_encode([]),
            ]);
        }

        $works = [
    [
        'creator' => 0, // Rani Mardiani
        'title' => 'Boneka Origami dari Sachet Kopi',
        'category' => 'Fashion & Accessories',
        'year' => 2025,
        'location' => 'Semarang, Jawa Tengah',
        'cover_image' => 'works/boneka-origami.jpg',
        'description' => 'Boneka origami hasil lipatan modular dari kemasan sachet kopi dan makanan ringan.',
        'story' => 'Berawal dari keresahan melihat sachet plastik multilayer yang tak diterima industri daur ulang manapun karena dianggap "sampah rosok". Setelah dua dekade menekuni dunia daur ulang, ditemukan teknik origami modular yang mengubah tiap lembar sachet jadi modul kecil, lalu dirakit jadi boneka dan aksesori bernilai jual tinggi.',
        'process' => 'Sachet dipilah berdasarkan warna dan ketebalan, dibersihkan dari residu, lalu dilipat menjadi modul-modul origami sebelum dirakit manual menjadi bentuk akhir.',
        'material' => 'Plastik',
        'waste_type' => 'Anorganik',
        'source' => 'Kemasan sachet kopi & makanan ringan, limbah rumah tangga sekitar Semarang',
        'quantity' => 1.2,
        'unit' => 'kg',
        'item_count' => 85,
        'processing_method' => 'Origami modular (dilipat manual tanpa lem/panas)',
    ],
    [
        'creator' => 1, // Amanda Prita
        'title' => 'Kursi Lipat dari Tutup Botol HDPE',
        'category' => 'Furniture',
        'year' => 2025,
        'location' => 'Sawangan, Depok',
        'cover_image' => 'works/kursi-lipat-hdpe.jpg',
        'description' => 'Kursi lipat ringan dengan rangka dari plastik HDPE hasil daur ulang tutup botol dan galon bekas.',
        'story' => 'Terinspirasi dari banyaknya tutup botol dan galon air minum yang berakhir di tempat sampah padahal jenis plastiknya (HDPE) termasuk paling mudah didaur ulang. Dikembangkan proses cetak ulang plastik jadi lembaran solid yang cukup kuat untuk furnitur fungsional.',
        'process' => 'Tutup botol dicacah jadi serpihan kecil, dilelehkan pada suhu terkontrol, dicetak jadi lembaran, lalu dipotong dan dirakit jadi kursi lipat.',
        'material' => 'Plastik',
        'waste_type' => 'Botol Plastik',
        'source' => 'Tutup botol & galon air minum, pengepul rumah tangga area Depok',
        'quantity' => 3.5,        
        'unit' => 'kg',
        'item_count' => null,
        'processing_method' => 'Pencacahan, peleburan, dan pencetakan ulang (injection molding sederhana)',
    ],
    [
        'creator' => 1, // Amanda Prita
        'title' => 'Lampu Baca dari Galon Plastik Bekas',
        'category' => 'Home Decor',
        'year' => 2024,
        'location' => 'Sawangan, Depok',
        'cover_image' => 'works/lampu-baca-galon.jpg',
        'description' => 'Lampu baca minimalis dengan badan lampu dari plastik daur ulang galon air minum.',
        'story' => 'Bagian dari lini produk furnitur plastik daur ulang, dirancang untuk kebutuhan pencahayaan rumah tangga dengan estetika yang tetap modern meski berasal dari limbah.',
        'process' => 'Galon dicacah dan dilelehkan menjadi granul, dicetak ulang menjadi badan lampu menggunakan cetakan custom.',
        'material' => 'Plastik',
        'waste_type' => 'Botol Plastik',
        'source' => 'Galon air minum bekas, depo isi ulang air minum sekitar Depok',
        'quantity' => 1.8,
        'unit' => 'kg',
        'item_count' => null,
        'processing_method' => 'Pencacahan, peleburan, dan pencetakan ulang',
    ],
    [
        'creator' => 2,
        'title' => 'Tas Anyam dari Kemasan Kopi Sachet',
        'category' => 'Fashion & Accessories',
        'year' => 2025,
        'location' => 'Duren Sawit, Jakarta Timur',
        'cover_image' => 'works/tas-anyam-kopi.jpg',
        'description' => 'Tas tangan hasil anyaman warga dari kemasan kopi sachet yang dibersihkan dan dianyam manual.',
        'story' => 'Salah satu produk unggulan komunitas bank sampah yang melibatkan ibu-ibu warga setempat. Dikerjakan secara gotong royong sebagai kegiatan pemberdayaan ekonomi rumah tangga.',
        'process' => 'Kemasan kopi dicuci dan dikeringkan, dipotong memanjang, lalu dianyam menggunakan teknik anyam dasar menjadi lembaran tas.',
        'material' => 'Plastik',
        'waste_type' => 'Anorganik',
        'source' => 'Kemasan kopi sachet, warga sekitar Duren Sawit',
        'quantity' => 0.9,
        'unit' => 'kg',
        'item_count' => 60,
        'processing_method' => 'Anyaman manual',
    ],
    [
        'creator' => 2, // Bank Sampah Melati
        'title' => 'Bunga Dekorasi dari Jas Hujan Plastik Bekas',
        'category' => 'Home Decor',
        'year' => 2024,
        'location' => 'Duren Sawit, Jakarta Timur',
        'cover_image' => 'works/bunga-dekorasi.jpg',
        'description' => 'Rangkaian bunga dekoratif dari plastik jas hujan sekali pakai yang dibentuk menyerupai kelopak bunga asli.',
        'story' => 'Ide muncul dari banyaknya jas hujan plastik sekali pakai yang menumpuk pasca musim hujan. Warna-warni plastiknya justru dimanfaatkan sebagai kelebihan estetika produk.',
        'process' => 'Plastik jas hujan dibersihkan, dipotong membentuk pola kelopak, dibentuk dengan panas ringan, lalu dirangkai pada tangkai kawat.',
        'material' => 'Plastik',
        'waste_type' => 'Anorganik',
        'source' => 'Jas hujan sekali pakai bekas, donasi warga & pengepul lokal',
        'quantity' => 0.6,
        'unit' => 'kg',
        'item_count' => 40,
        'processing_method' => 'Pemotongan pola & pembentukan panas ringan',
    ],
];

        foreach ($works as $data) {
            $work = Work::create([
                'creator_id' => $creators[$data['creator']]->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'category' => $data['category'],
                'year' => $data['year'],
                'location' => $data['location'],
                'story' => $data['story'],
                'process' => $data['process'],
                'status' => 'published',
                'cover_image' => $data['cover_image'],
                'is_featured' => false,
                'published_at' => now()->subDays(rand(1, 60)),
            ]);

            WasteDna::create([
                'work_id' => $work->id,
                'material' => $data['material'],
                'waste_type' => $data['waste_type'],
                'source' => $data['source'],
                'quantity' => $data['quantity'],
                'unit' => $data['unit'],
                'item_count' => $data['item_count'],
                'processing_method' => $data['processing_method'],
            ]);
        }
    }
}