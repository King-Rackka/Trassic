<?php

namespace App\Livewire\Work;

use App\Models\Work;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkEdit extends Component
{
    use WithFileUploads;

    public Work $work;

    public $title;
    public $tags;
    public $description;
    public $allowComments = true;

    // Foto Handling
    public $existingImages = [];
    public $newImages = [];
    public $activeType = 'existing';
    public $activeIndex = 0;

    public $wasteDetails = [];

    public function mount(Work $work)
    {
        // Cek Akses
        $currentUserId = Auth::id();
        if ($work->user_id != $currentUserId && optional($work->creator)->user_id != $currentUserId) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $this->work = $work;
        $this->title = $work->title;
        $this->description = $work->description;
        $this->allowComments = $work->allow_comments ?? true;

        // --- 1. LOAD TAGS (sudah otomatis array via casts) ---
        $this->tags = implode(', ', $work->tags ?? []);

        // --- 2. LOAD EXISTING IMAGES (Cegah Duplikat Sejak Awal) ---
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
        unset($this->wasteDetails[$index]);
        $this->wasteDetails = array_values($this->wasteDetails);
    }

    public function selectSuggestedTag($tag)
    {
        $current = array_filter(array_map('trim', explode(',', $this->tags ?? '')));
        if (!in_array($tag, $current)) {
            $current[] = $tag;
        }
        $this->tags = implode(', ', $current);
    }

    public function update()
    {
        // Bersihkan format koma berat ke titik
        foreach ($this->wasteDetails as $key => $detail) {
            if (isset($detail['weight'])) {
                $this->wasteDetails[$key]['weight'] = str_replace(',', '.', $detail['weight']);
            }
        }

        $this->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'wasteDetails.*.waste_type' => 'required|string',
            'wasteDetails.*.weight' => 'required|numeric',
        ]);

        // 1. Upload foto baru jika ada
        $uploadedPaths = [];
        foreach ($this->newImages as $img) {
            $uploadedPaths[] = $img->store('works', 'public');
        }

        // Gabungkan dengan gambar lama dan bersihkan duplikat
        $allImages = array_values(array_unique(array_merge($this->existingImages, $uploadedPaths)));
        $coverImage = $allImages[0] ?? null;

        // 2. Update Informasi Utama Karya
        $this->work->update([
            'title' => $this->title,
            'description' => $this->description,
            'tags' => array_filter(array_map('trim', explode(',', $this->tags ?? ''))),
            'allow_comments' => $this->allowComments,
            'cover_image' => $coverImage,
        ]);

        // 3. Sinkronisasi Tabel Relasi `images` secara bersih
        if (method_exists($this->work, 'images')) {
            $this->work->images()->delete();
            foreach ($allImages as $path) {
                $this->work->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // 4. Re-sync detail sampah (Waste DNA)
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