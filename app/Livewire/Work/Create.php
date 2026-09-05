<?php

namespace App\Livewire\Work;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Work;
use App\Models\CreatorProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class Create extends Component  
{
    use WithFileUploads;

    // Foto Galeri
    public $images = [];
    public $activeImageIndex = 0;
    public $replacementImage;

    // Form Utama
    public $title = '';
    public $category = 'Daur Ulang';
    public $year = '';
    public $tags = '';
    public $description = '';
    public $allowComments = true;
    //tag sampah
    public $selectedTags = []; // Menyimpan tag yang sudah dipilih
    public $tagSearch = '';    // Kata kunci yang sedang diketik di input
    

    // Detail Penggunaan Sampah
    public $wasteDetails = [
        [
            'waste_type' => '',
            'waste_source' => '',
            'weight' => '',
            'unit' => 'gram',
            'support_materials' => ['', '', '', '']
        ]
    ];

    public function mount()
    {
        $this->year = date('Y');
    }

    public function updatedImages()
    {
        if (count($this->images) > 10) {
            $this->images = array_slice($this->images, 0, 10);
            session()->flash('error', 'Maksimal upload 10 foto.');
        }
        $this->activeImageIndex = max(0, count($this->images) - 1);
    }

    public function updatedReplacementImage()
    {
        $this->validate([
            'replacementImage' => 'image|max:3072',
        ], [
            'replacementImage.image' => 'File harus berupa gambar.',
            'replacementImage.max' => 'Ukuran gambar maksimal 3MB.',
        ]);

        if (isset($this->images[$this->activeImageIndex])) {
            // Timpa gambar pada index yang sedang dipilih
            $this->images[$this->activeImageIndex] = $this->replacementImage;
        }

        // Reset kembali penampung sementaranya
        $this->replacementImage = null;
    }
   

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
        if ($this->activeImageIndex >= count($this->images)) {
            $this->activeImageIndex = max(0, count($this->images) - 1);
        }
    }
    // Menambah tag ke daftar terpilih
    public function addTag($tagName)
    {
        $cleanTag = trim($tagName);
        if ($cleanTag && !in_array($cleanTag, $this->selectedTags)) {
            $this->selectedTags[] = $cleanTag;
        }
        $this->tagSearch = ''; // Reset input
    }

    // Menghapus tag saat tombol silang (x) ditekan
    public function removeTag($index)
    {
        unset($this->selectedTags[$index]);
        $this->selectedTags = array_values($this->selectedTags);
    }

    // Fungsi klik tombol suggested tags di bawah
    public function selectSuggestedTag($sTag)
    {
        $this->addTag($sTag);
    }

    // Ambil hasil pencarian untuk dropdown suggestion
    #[Computed]
    public function tagSuggestions()
    {
        $search = trim($this->tagSearch);

        try {
            $query = \App\Models\Tag::query();

            // Sembunyikan tag yang sudah dipilih
            if (!empty($this->selectedTags)) {
                $query->whereNotIn('name', $this->selectedTags);
            }

            // Jika sedang mengetik, cari yang cocok
            if ($search !== '') {
                $query->where('name', 'like', '%' . $search . '%');
            }

            return $query->take(6)->pluck('name')->toArray();
        } catch (\Throwable $e) {
            // Fallback jika database belum siap
            $list = ['Organik', 'Anorganik', 'Plastik HDPE', 'Plastik PET', 'Minyak Jelantah', 'Kardus', 'Kain Perca'];
            return array_values(array_filter($list, function ($item) use ($search) {
                return !in_array($item, $this->selectedTags) && ($search === '' || stripos($item, $search) !== false);
            }));
        }
    }

    public function addWasteCategory()
    {
        $this->wasteDetails[] = [
            'waste_type' => '',
            'waste_source' => '',
            'weight' => '',
            'unit' => 'gram',
            'support_materials' => ['', '', '', '']
        ];
    }

    public function removeWasteCategory($index)
    {
        if (count($this->wasteDetails) > 1) {
            unset($this->wasteDetails[$index]);
            $this->wasteDetails = array_values($this->wasteDetails);
        }
    }

    public function save()
{
    $this->validate([
        'images' => 'required|array|min:1|max:10',
        'images.*' => 'image|max:3072',
        'title' => 'required|string|max:100',
        'description' => 'required|string',
        'wasteDetails.*.waste_type' => 'required|string',
        'wasteDetails.*.weight' => 'required|numeric',
    ]);

    $user = Auth::user();
    $creator = CreatorProfile::where('user_id', $user->id)->firstOrFail();

    // 1. Upload Foto
    $imagePaths = [];
    foreach ($this->images as $image) {
        $imagePaths[] = $image->store('works', 'public');
    }

    // 2. Hitung Total Berat Sampah dalam KG untuk Target
    $totalWeightInKg = 0;
    foreach ($this->wasteDetails as $detail) {
        $weightInKg = ($detail['unit'] === 'gram' || $detail['unit'] === 'g') 
            ? $detail['weight'] / 1000 
            : $detail['weight'];
        $totalWeightInKg += (float) $weightInKg;
    }

    // 3. Simpan Data Ke Tabel `works`
    $work = Work::create([
        'creator_id'      => $creator->id,
        'title'           => $this->title,
        'slug'            => Str::slug($this->title) . '-' . Str::random(5),
        'category'        => !empty($this->category) ? $this->category : 'Daur Ulang',
        'year'            => $this->year ?? date('Y'),
        'cover_image'     => $imagePaths[0],
        'description'     => $this->description,
        'target_quantity' => $totalWeightInKg, // Total target dalam KG
        'status'          => 'published',
        'published_at'    => now(),
    ]);

    // 4. Simpan Galeri Foto
    if (method_exists($work, 'images')) {
        foreach ($imagePaths as $index => $path) {
            $work->images()->create([
                'image_path' => $path,
                'sort_order' => $index,
            ]);
        }
    }

    // 5. Simpan Detail DNA Sampah (Simpan Angka Asli Sesuai Input User)
    foreach ($this->wasteDetails as $detail) {
        $supportMaterials = array_values(array_filter($detail['support_materials']));
        
        // Simpan 'g' jika user memilih gram
        $unit = ($detail['unit'] === 'gram') ? 'g' : $detail['unit'];

        if (method_exists($work, 'wasteDna')) {
            $work->wasteDna()->create([
                'material'             => $detail['waste_type'],
                'waste_type'           => $detail['waste_type'],
                'source'               => $detail['waste_source'],
                'quantity'             => $detail['weight'], // Simpan angka asli yang diketik user
                'unit'                 => $unit,            // Simpan 'g' atau 'kg'
                'supporting_materials' => json_encode($supportMaterials),
            ]);
        }
    }

    session()->flash('message', 'Karya berhasil dipublikasikan!');
    return redirect()->route('profile.show');
}

    public function render()
    {
        return view('livewire.work.create');
    }
}