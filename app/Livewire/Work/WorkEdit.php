<?php

namespace App\Livewire\Work;

use App\Models\Work;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkEdit extends Component
{
    use WithFileUploads;

    public Work $work;

    public $title;
    public $selectedTags = [];
    public $tagSearch = '';
    public $description;
    public $allowComments = true;

    // Foto Handling
    public $existingImages = [];
    public $newImages = [];
    public $replacementImage;
    public $activeType = 'existing';
    public $activeIndex = 0;

    public $wasteDetails = [];

    public function mount(Work $work)
    {
        // Cek Akses Hak Milik Karya
        $currentUserId = Auth::id();
        if ($work->user_id != $currentUserId && optional($work->creator)->user_id != $currentUserId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $this->work = $work;
        $this->title = $work->title;
        $this->description = $work->description;
        $this->allowComments = $work->allow_comments ?? true;

        // --- 1. LOAD TAGS KE DALAM ARRAY CHIPS ---
        if (is_array($work->tags)) {
            $this->selectedTags = array_values(array_filter(array_map('trim', $work->tags)));
        } elseif (is_string($work->tags) && !empty($work->tags)) {
            $this->selectedTags = array_values(array_filter(array_map('trim', explode(',', $work->tags))));
        } elseif (!empty($work->category)) {
            $this->selectedTags = array_values(array_filter(array_map('trim', explode(',', $work->category))));
        } else {
            $this->selectedTags = [];
        }

        // --- 2. LOAD EXISTING IMAGES ---
        $imagesList = [];

        if (method_exists($work, 'images') && $work->images) {
            foreach ($work->images as $imgObj) {
                $path = is_string($imgObj) ? $imgObj : ($imgObj->image_path ?? null);
                if ($path && !in_array($path, $imagesList)) {
                    $imagesList[] = $path;
                }
            }
        }

        if (empty($imagesList) && $work->cover_image) {
            $imagesList[] = $work->cover_image;
        }

        $this->existingImages = array_values($imagesList);
        if (count($this->existingImages) > 0) {
            $this->activeType = 'existing';
            $this->activeIndex = 0;
        }

        // --- 3. LOAD WASTE DNA ---
        $this->wasteDetails = [];
        $wasteCollection = $work->wasteDna ?? [];

        foreach ($wasteCollection as $w) {
            $supp = array_pad((array) ($w->supporting_materials ?? []), 4, '');

            $type   = $w->waste_type ?? $w->material ?? '';
            $source = $w->source ?? '';
            $weight = $w->quantity ?? '';
            $unit   = $w->unit ?? 'gram';

            $this->wasteDetails[] = [
                'id' => $w->id,
                'waste_type'   => $type,
                'waste_source' => $source,
                'weight'       => $weight,
                'unit'         => $unit,
                'supporting_materials' => $supp,
            ];
        }

        if (empty($this->wasteDetails)) {
            $this->addWasteCategory();
        }
    }

    public function updatedNewImages()
    {
        if (count($this->newImages) > 0) {
            $this->activeType = 'new';
            $this->activeIndex = count($this->newImages) - 1;
        }
    }

    // Ganti gambar yang sedang aktif/dipilih
    public function updatedReplacementImage()
    {
        $this->validate([
            'replacementImage' => 'image|max:3072',
        ], [
            'replacementImage.image' => 'File harus berupa gambar.',
            'replacementImage.max' => 'Ukuran gambar maksimal 3MB.',
        ]);

        if ($this->activeType === 'existing' && isset($this->existingImages[$this->activeIndex])) {
            // Langsung simpan file pengganti ke storage agar path-nya tetap valid
            $path = $this->replacementImage->store('works', 'public');
            $this->existingImages[$this->activeIndex] = $path;
        } elseif ($this->activeType === 'new' && isset($this->newImages[$this->activeIndex])) {
            $this->newImages[$this->activeIndex] = $this->replacementImage;
        }

        $this->replacementImage = null;
    }

    public function getCurrentPreviewUrlProperty()
    {
        if ($this->activeType === 'existing' && isset($this->existingImages[$this->activeIndex])) {
            return asset('storage/' . $this->existingImages[$this->activeIndex]);
        }

        if ($this->activeType === 'new' && isset($this->newImages[$this->activeIndex])) {
            return $this->newImages[$this->activeIndex]->temporaryUrl();
        }

        return null;
    }

    public function setPreview($type, $index)
    {
        $this->activeType = $type;
        $this->activeIndex = $index;
    }

    public function removeExistingImage($index)
    {
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);
        $this->activeIndex = 0;
        $this->activeType = count($this->existingImages) > 0 ? 'existing' : (count($this->newImages) > 0 ? 'new' : null);
    }

    public function removeNewImage($index)
    {
        unset($this->newImages[$index]);
        $this->newImages = array_values($this->newImages);
        $this->activeIndex = 0;
        $this->activeType = count($this->existingImages) > 0 ? 'existing' : (count($this->newImages) > 0 ? 'new' : null);
    }

    public function addWasteCategory()
    {
        $this->wasteDetails[] = [
            'id' => null,
            'waste_type' => '',
            'waste_source' => '',
            'weight' => '',
            'unit' => 'gram',
            'supporting_materials' => ['', '', '', ''],
        ];
    }

    public function removeWasteCategory($index)
    {
        if (count($this->wasteDetails) > 1) {
            unset($this->wasteDetails[$index]);
            $this->wasteDetails = array_values($this->wasteDetails);
        }
    }

    // --- LOGIKA SISTEM TAGS ---
    public function addTag($tagName = null)
    {
        $cleanTag = trim($tagName ?? $this->tagSearch);

        if ($cleanTag && !in_array($cleanTag, $this->selectedTags)) {
            $this->selectedTags[] = $cleanTag;
        }

        $this->tagSearch = '';
    }

    public function removeTag($index)
    {
        unset($this->selectedTags[$index]);
        $this->selectedTags = array_values($this->selectedTags);
    }

    public function selectSuggestedTag($sTag)
    {
        $this->addTag($sTag);
    }

    #[Computed]
    public function tagSuggestions()
    {
        $search = trim($this->tagSearch);

        $defaultTags = [
            'Organik', 'Anorganik', 'Plastik HDPE', 'Plastik PET', 'Plastik Sachet',
            'Kantong Kresek', 'Minyak Jelantah', 'Kardus', 'Kertas Koran', 'Kertas Bekas',
            'Botol Kaca', 'Kain Perca', 'Kaleng Aluminium', 'Limbah Kulit', 'Ampas Kopi',
            'Tempurung Kelapa', 'Serpihan Kayu', 'Limbah B3'
        ];

        try {
            if (Tag::count() > 0) {
                $query = Tag::query();

                if (!empty($this->selectedTags)) {
                    $query->whereNotIn('name', $this->selectedTags);
                }

                if ($search !== '') {
                    $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                }

                return $query->take(6)->pluck('name')->toArray();
            }
        } catch (\Throwable $e) {
            // Fallback ke array default jika tabel belum siap
        }

        return array_values(array_filter($defaultTags, function ($item) use ($search) {
            $isNotSelected = !in_array($item, $this->selectedTags);
            $matchesSearch = ($search === '' || stripos($item, $search) !== false);
            return $isNotSelected && $matchesSearch;
        }));
    }

    public function update()
    {
        // Ubah koma ke titik pada berat sampah
        foreach ($this->wasteDetails as $key => $detail) {
            if (isset($detail['weight'])) {
                $this->wasteDetails[$key]['weight'] = str_replace(',', '.', $detail['weight']);
            }
        }

        $this->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'wasteDetails.*.waste_type' => 'required|string',
            'wasteDetails.*.weight' => 'required|numeric|min:0.01',
        ]);

        // 1. Simpan foto-foto baru
        $uploadedPaths = [];
        foreach ($this->newImages as $img) {
            $uploadedPaths[] = $img->store('works', 'public');
        }

        // Satukan gambar lama dan gambar baru
        $allImages = array_values(array_unique(array_merge($this->existingImages, $uploadedPaths)));
        $coverImage = $allImages[0] ?? null;

        // 2. Simpan Pembaruan Data Karya
        $this->work->update([
            'title'          => $this->title,
            'description'    => $this->description,
            'category'       => count($this->selectedTags) ? implode(', ', $this->selectedTags) : ($this->work->category ?? 'Art & Craft'),
            'cover_image'    => $coverImage,
        ]);

        // 3. Sinkronisasi Tabel Relasi images
        if (method_exists($this->work, 'images')) {
            $this->work->images()->delete();
            foreach ($allImages as $path) {
                $this->work->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // 4. Sinkronisasi Data Waste DNA
        $this->work->wasteDna()->delete();
        foreach ($this->wasteDetails as $waste) {
            if (!empty($waste['waste_type'])) {
                $this->work->wasteDna()->create([
                    'waste_type'   => $waste['waste_type'],
                    'material'     => $waste['waste_type'],
                    'source'       => $waste['waste_source'] ?? null,
                    'quantity'     => $waste['weight'],
                    'unit'         => $waste['unit'],
                    'supporting_materials' => array_values(array_filter($waste['supporting_materials'] ?? [])),
                ]);
            }
        }

        $this->newImages = [];

        session()->flash('message', 'Karya berhasil diperbarui!');
        return redirect()->route('profile.show');
    }

    public function render()
    {
        return view('livewire.work.edit');
    }
}