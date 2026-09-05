<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $wasteTags = [
            'Organik',
            'Anorganik',
            'Plastik HDPE',
            'Plastik PET',
            'Plastik Sachet',
            'Kantong Kresek',
            'Minyak Jelantah',
            'Kardus',
            'Kertas Koran',
            'Kertas Bekas',
            'Botol Kaca',
            'Kain Perca',
            'Kaleng Aluminium',
            'Limbah Kulit',
            'Ampas Kopi',
            'Tempurung Kelapa',
            'Serpihan Kayu',
            'Limbah B3'
        ];

        foreach ($wasteTags as $tagName) {
            Tag::firstOrCreate(
                ['name' => $tagName],
                ['slug' => Str::slug($tagName)]
            );
        }
    }
}