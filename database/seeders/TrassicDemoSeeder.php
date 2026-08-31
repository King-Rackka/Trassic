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
        // ===== 1. Users + Creator Profiles =====
        $creatorsData = [
            [
                'name' => 'Rani Mardiani',
                'email' => 'rani.mardiani@example.com',
                'creator_type' => 'umkm',
                'bio' => 'Menekuni teknik origami multilayer dari plastik sachet sejak 2020. Mengubah limbah "rosok" yang tak laku dijual jadi kerajinan bernilai tinggi.',
                'location' => 'Semarang, Jawa Tengah',
                'phone' => '+62 812-3456-7890',
                'website' => 'https://ranicraft.id',
                'instagram' => '@rani.origami',
            ],
            [
                'name' => 'Amanda Prita',
                'email' => 'amanda.prita@example.com',
                'creator_type' => 'studio',
                'bio' => 'Bersama dua rekannya membangun studio furnitur dari tutup botol dan galon plastik HDPE bekas sejak Juni 2023, melibatkan warga sekitar sebagai perajin.',
                'location' => 'Sawangan, Depok',
                'phone' => '+62 813-8899-7711',
                'website' => 'https://amandastudio.co',
                'instagram' => '@amanda.upcycle',
            ],
            [
                'name' => 'Bank Sampah Melati',
                'email' => 'melati.banksampah@example.com',
                'creator_type' => 'community',
                'bio' => 'Komunitas warga yang mengolah sampah kemasan kopi, jas hujan plastik, dan botol kaca jadi produk kerajinan rumah tangga.',
                'location' => 'Duren Sawit, Jakarta Timur',
                'phone' => '+62 821-2233-4455',
                'website' => 'https://banksampahmelati.org',
                'instagram' => '@bs.melati_durensawit',
            ],
            [
                'name' => 'Wati Prihatinia Dewi',
                'email' => 'wati.kiziecraft@example.com',
                'creator_type' => 'umkm',
                'bio' => 'Pemilik Kizie Craft, mengubah sampah kantong plastik jadi kerajinan bunga hias bernilai jual tinggi.',
                'location' => 'Cibodas, Kota Tangerang',
                'phone' => '+62 857-1122-3344',
                'website' => 'https://kiziecraft.com',
                'instagram' => '@kizie_craft',
            ],
            [
                'name' => 'Ernik Yustiana',
                'email' => 'ernik.yustcollection@example.com',
                'creator_type' => 'umkm',
                'bio' => 'Pemilik Yust Collection, mengolah aneka sampah nonlogam (kertas, plastik, gelas, kain perca, kulit) jadi barang estetik. Beralih usaha dari pembatik tulis sejak 2017, produknya sudah dipesan hingga luar pulau.',
                'location' => 'Malang, Jawa Timur',
                'phone' => '+62 878-9900-1122',
                'website' => 'https://yustcollection.id',
                'instagram' => '@yust_collection',
            ],
            [
                'name' => 'Denok Marty Astuti',
                'email' => 'denok.kardus@example.com',
                'creator_type' => 'individual',
                'bio' => 'Pengrajin miniatur dari kardus bekas dan kain perca. Karyanya sempat jadi perhatian pengunjung dalam pameran Java Expo di Solo.',
                'location' => 'Laweyan, Solo',
                'phone' => '+62 815-4455-6677',
                'website' => 'https://denokart.com',
                'instagram' => '@denok.miniatur',
            ],
            [
                'name' => 'CV. Bina Usaha Mandiri',
                'email' => 'binausahamandiri@example.com',
                'creator_type' => 'umkm',
                'bio' => 'Perusahaan yang bergerak di industri kreatif kerajinan daur ulang kertas koran.',
                'location' => 'Jawa Tengah',
                'phone' => '+62 24-7654321',
                'website' => 'https://binausahamandiri.co.id',
                'instagram' => '@binausaha_mandiri',
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
                'phone' => $data['phone'] ?? null,
                'social_links' => [
                    'website' => $data['website'] ?? null,
                    'instagram' => $data['instagram'] ?? null,
                ],
            ]);
        }

        // Index creator: 0 Rani, 1 Amanda, 2 Bank Sampah Melati, 3 Wati, 4 Ernik, 5 Denok, 6 CV Bina Usaha Mandiri

        // ===== 2. Works + WasteDNA =====
        $works = [
            // --- Rani Mardiani ---
            [
                'creator' => 0,
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
                'quantity' => 1.2, 'unit' => 'kg', 'item_count' => 85,
                'processing_method' => 'Origami modular (dilipat manual tanpa lem/panas)',
            ],

            // --- Amanda Prita (3 karya) ---
            [
                'creator' => 1,
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
                'quantity' => 3.5, 'unit' => 'kg', 'item_count' => null,
                'processing_method' => 'Pencacahan, peleburan, dan pencetakan ulang (injection molding sederhana)',
            ],
            [
                'creator' => 1,
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
                'quantity' => 1.8, 'unit' => 'kg', 'item_count' => null,
                'processing_method' => 'Pencacahan, peleburan, dan pencetakan ulang',
            ],
            [
                'creator' => 1,
                'title' => 'Gantungan Kunci dari Serpihan HDPE',
                'category' => 'Fashion & Accessories',
                'year' => 2025,
                'location' => 'Sawangan, Depok',
                'cover_image' => 'works/gantungan-kunci-hdpe.jpg',
                'description' => 'Gantungan kunci warna-warni dari serpihan plastik HDPE sisa produksi furnitur.',
                'story' => 'Dibuat memanfaatkan sisa material dari proses produksi kursi dan lampu, supaya tidak ada serpihan plastik yang terbuang percuma dari lini produksi utama.',
                'process' => 'Serpihan sisa dicetak ulang dalam cetakan kecil, dipadatkan, lalu dipotong dan dihaluskan menjadi bentuk gantungan kunci.',
                'material' => 'Plastik',
                'waste_type' => 'Botol Plastik',
                'source' => 'Sisa serpihan produksi furnitur HDPE',
                'quantity' => 0.4, 'unit' => 'kg', 'item_count' => 50,
                'processing_method' => 'Pencetakan ulang dari sisa material produksi',
            ],

            // --- Bank Sampah Melati (2 karya) ---
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
                'quantity' => 0.9, 'unit' => 'kg', 'item_count' => 60,
                'processing_method' => 'Anyaman manual',
            ],
            [
                'creator' => 2,
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
                'quantity' => 0.6, 'unit' => 'kg', 'item_count' => 40,
                'processing_method' => 'Pemotongan pola & pembentukan panas ringan',
            ],

            // --- Wati Prihatinia Dewi / Kizie Craft (2 karya) ---
            [
                'creator' => 3,
                'title' => 'Bunga Hias Plastik Kizie Craft (Varian Mawar)',
                'category' => 'Art & Craft',
                'year' => 2025,
                'location' => 'Cibodas, Kota Tangerang',
                'cover_image' => 'works/bunga-mawar-kizie.jpg',
                'description' => 'Bunga hias dari kantong plastik bekas, dibentuk menyerupai mawar untuk hadiah dan dekorasi.',
                'story' => 'Sampah plastik, apalagi tas kresek, butuh puluhan hingga ratusan tahun untuk terurai. Kesadaran ini mendorong pembuatan kerajinan bunga hias yang mengubah kantong plastik jadi produk bernilai jual, cocok untuk hadiah ulang tahun maupun wisuda.',
                'process' => 'Kantong plastik dibersihkan, dipotong membentuk pola kelopak bunga, lalu dirangkai dengan tangkai kawat. Satu bunga memakan waktu 30-60 menit tergantung kerumitan model.',
                'material' => 'Plastik',
                'waste_type' => 'Anorganik',
                'source' => 'Kantong plastik/tas kresek bekas rumah tangga',
                'quantity' => 0.3, 'unit' => 'kg', 'item_count' => 15,
                'processing_method' => 'Pemotongan pola & perangkaian manual',
            ],
            [
                'creator' => 3,
                'title' => 'Bunga Hias Plastik Kizie Craft (Varian Anggrek)',
                'category' => 'Art & Craft',
                'year' => 2025,
                'location' => 'Cibodas, Kota Tangerang',
                'cover_image' => 'works/bunga-anggrek-kizie.jpg',
                'description' => 'Bunga hias anggrek dari kantong plastik warna-warni, dipasarkan lewat media sosial.',
                'story' => 'Dipasarkan lewat Instagram dan mendapat atensi tinggi dari pecinta bunga di Kota Tangerang bahkan luar kota, produk ini jadi bukti bahwa sampah plastik bisa disulap jadi barang bernilai jual tinggi.',
                'process' => 'Plastik dipotong menyerupai kelopak anggrek, dibentuk dengan panas ringan, lalu dirangkai bertingkat pada tangkai kawat.',
                'material' => 'Plastik',
                'waste_type' => 'Anorganik',
                'source' => 'Kantong plastik bekas berbagai warna',
                'quantity' => 0.35, 'unit' => 'kg', 'item_count' => 18,
                'processing_method' => 'Pemotongan pola, pembentukan panas ringan, & perangkaian manual',
            ],

            // --- Ernik Yustiana / Yust Collection (3 karya) ---
            [
                'creator' => 4,
                'title' => 'Tas dari Kain Perca Yust Collection',
                'category' => 'Fashion & Accessories',
                'year' => 2025,
                'location' => 'Malang, Jawa Timur',
                'cover_image' => 'works/tas-kain-perca-yust.jpg',
                'description' => 'Tas tangan dari sisa kain perca yang dijahit dan dianyam menjadi motif unik.',
                'story' => 'Yustin beralih dari usaha membatik tulis setelah konversi minyak tanah ke elpiji tahun 2015 membuat usahanya sepi. Ia menemukan peluang baru mengolah sampah nonlogam termasuk kain perca jadi produk yang sudah dipesan hingga ke luar pulau seperti Sumatra, Kalimantan, dan Bali.',
                'process' => 'Kain perca dipilah berdasarkan warna dan tekstur, dipotong pola, dijahit, dan dirangkai menjadi badan tas.',
                'material' => 'Tekstil',
                'waste_type' => 'Kain Perca',
                'source' => 'Sisa kain perca dari konveksi/penjahit sekitar Malang',
                'quantity' => 0.7, 'unit' => 'kg', 'item_count' => null,
                'processing_method' => 'Penjahitan & anyaman manual',
            ],
            [
                'creator' => 4,
                'title' => 'Dompet dari Sisa Kulit & Kain Perca',
                'category' => 'Fashion & Accessories',
                'year' => 2024,
                'location' => 'Malang, Jawa Timur',
                'cover_image' => 'works/dompet-kulit-yust.jpg',
                'description' => 'Dompet kombinasi sisa kulit dan kain perca, dijahit rapi dengan sentuhan estetik.',
                'story' => 'Salah satu produk andalan Yust Collection yang memanfaatkan sisa kulit dari produsen tas/sepatu, dipadukan dengan kain perca supaya tidak ada material yang terbuang percuma.',
                'process' => 'Sisa kulit dan kain perca dipotong pola, dijahit menyatu, lalu diberi finishing jahitan tepi.',
                'material' => 'Tekstil',
                'waste_type' => 'Kain Perca',
                'source' => 'Sisa kulit dan kain perca dari pengrajin lokal',
                'quantity' => 0.5, 'unit' => 'kg', 'item_count' => null,
                'processing_method' => 'Pemotongan pola & penjahitan manual',
            ],
            [
                'creator' => 4,
                'title' => 'Tas Gulung dari Lembaran Kertas Bekas',
                'category' => 'Fashion & Accessories',
                'year' => 2024,
                'location' => 'Malang, Jawa Timur',
                'cover_image' => 'works/tas-gulung-kertas-yust.jpg',
                'description' => 'Tas dari lembaran kertas bekas yang digulung dan dianyam menyerupai tekstur rotan.',
                'story' => 'Yustin mengajari tetangga sekitar cara menggulung kertas bekas jadi bahan anyaman, meski proses ini butuh ketelatenan tinggi sehingga sebagian besar produksi tetap ia kerjakan sendiri.',
                'process' => 'Lembaran kertas digulung memanjang menjadi "benang" kertas, lalu dianyam membentuk badan tas.',
                'material' => 'Kertas',
                'waste_type' => 'Kertas',
                'source' => 'Kertas bekas rumah tangga & sisa percetakan',
                'quantity' => 0.6, 'unit' => 'kg', 'item_count' => null,
                'processing_method' => 'Penggulungan & anyaman manual',
            ],

            // --- Denok Marty Astuti (1 karya) ---
            [
                'creator' => 5,
                'title' => 'Miniatur Kapal Pinisi dari Kardus Bekas',
                'category' => 'Art & Craft',
                'year' => 2025,
                'location' => 'Laweyan, Solo',
                'cover_image' => 'works/miniatur-pinisi-kardus.jpg',
                'description' => 'Miniatur perahu layar tradisional Pinisi dengan corak batik, dibuat dari kardus bekas dan kain perca.',
                'story' => 'Meski bahan bakunya dari kardus bekas dan kain perca, hasilnya terlihat sangat indah dan mewah sehingga banyak pengunjung tidak menyangka bahan aslinya. Karya ini sempat menjadi perhatian pengunjung saat pameran Java Expo di Solo, dan merupakan hasil kolaborasi dengan warga binaan Rutan Kelas I Surakarta.',
                'process' => 'Kardus dipotong dan dibentuk mengikuti kerangka perahu, dilapisi kain perca bercorak batik, lalu dirakit dan diberi detail tiang layar.',
                'material' => 'Kardus',
                'waste_type' => 'Kardus',
                'source' => 'Kardus bekas dan sisa kain perca',
                'quantity' => 1.0, 'unit' => 'kg', 'item_count' => null,
                'processing_method' => 'Pemotongan, pembentukan kerangka, & pelapisan kain',
            ],

            // --- CV. Bina Usaha Mandiri (1 karya) ---
            [
                'creator' => 6,
                'title' => 'Kotak Serbaguna dari Kertas Koran Daur Ulang',
                'category' => 'Home Decor',
                'year' => 2024,
                'location' => 'Jawa Tengah',
                'cover_image' => 'works/kotak-koran-daur-ulang.jpg',
                'description' => 'Kotak penyimpanan serbaguna dari lembaran kertas koran bekas yang dipadatkan dan dianyam.',
                'story' => 'Salah satu produk industri kreatif kerajinan daur ulang kertas koran, dikembangkan sebagai bagian dari upaya keberlanjutan usaha di sektor industri kreatif berbasis limbah kertas.',
                'process' => 'Kertas koran digulung menjadi lembaran padat, dianyam membentuk kerangka kotak, lalu dilapis finishing agar lebih kokoh.',
                'material' => 'Kertas',
                'waste_type' => 'Kertas',
                'source' => 'Kertas koran bekas',
                'quantity' => 0.8, 'unit' => 'kg', 'item_count' => null,
                'processing_method' => 'Penggulungan, anyaman, & finishing',
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