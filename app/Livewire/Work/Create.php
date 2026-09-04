<?php

namespace App\Livewire\Work;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Work;
use App\Models\CreatorProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;

    // Foto Galeri
    public $images = [];
    public $activeImageIndex = 0;

    // Form Utama
    public $title = '';
    public $category = 'Daur Ulang';
    public $year = '';
    public $tags = '';
    public $description = '';
    public $allowComments = true;

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

    public function selectSuggestedTag($tag)
    {
        $currentTags = array_filter(array_map('trim', explode(',', $this->tags)));
        if (!in_array($tag, $currentTags)) {
            $currentTags[] = $tag;
            $this->tags = implode(', ', $currentTags);
        }
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
        if ($this->activeImageIndex >= count($this->images)) {
            $this->activeImageIndex = max(0, count($this->images) - 1);
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