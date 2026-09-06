<?php

namespace App\Livewire;

use App\Models\Work;
use App\Models\CreatorProfile;
use App\Models\WasteDna;
use Livewire\Component;

class WasteImpact extends Component
{
    public function render()
    {
        $totalWasteKg = WasteDna::whereHas('work', function ($q) {
                $q->where('status', 'published');
            })
            ->where('unit', 'kg')
            ->sum('quantity');

        $publishedWorksCount = Work::where('status', 'published')->count();

        $activeCreatorsCount = CreatorProfile::whereHas('works', function ($q) {
                $q->where('status', 'published');
            })->count();

        $topMaterials = WasteDna::whereHas('work', function ($q) {
            $q->where('status', 'published');
        })
        ->selectRaw("material, SUM(CASE WHEN unit = 'g' THEN quantity / 1000 ELSE quantity END) as total_qty")
        ->whereIn('unit', ['kg', 'g']) 
        ->groupBy('material')
        ->orderByDesc('total_qty')
        ->take(5)
        ->get();

        $maxQty = $topMaterials->max('total_qty') ?: 1;
        $topMaterials = $topMaterials->map(function ($item) use ($maxQty) {
            $item->percentage = round(($item->total_qty / $maxQty) * 100, 1);
            return $item;
        });

        return view('livewire.waste-impact', [
            'totalWasteKg' => $totalWasteKg,
            'publishedWorksCount' => $publishedWorksCount,
            'activeCreatorsCount' => $activeCreatorsCount,
            'topMaterials' => $topMaterials,
        ]);
    }
}