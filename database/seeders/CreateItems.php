<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Item;

class CreateItems extends Seeder
{
    public function run(): void
    {
        Item::query()->create([
            'name' => 'Lidocaine XYZ 50mg',
            'description' => 'desc1',
            'brand_id' => Brand::query()->inRandomOrder()->first()->id,
            'threshold_quantity' => 5,
        ]);
        Item::query()->create([
            'name' => 'Lidocaine XYZ 100mg',
            'description' => 'desc1',
            'brand_id' => Brand::query()->inRandomOrder()->first()->id,
            'threshold_quantity' => 5,
        ]);
        Item::query()->create([
            'name' => 'Lidocaine ABC 50mg',
            'description' => 'desc2',
            'brand_id' => Brand::query()->inRandomOrder()->first()->id,
            'threshold_quantity' => 5,
        ]);
        Item::query()->create([
            'name' => 'Lidocaine ABC 100mg',
            'brand_id' => Brand::query()->inRandomOrder()->first()->id,
            'description' => 'desc2',
            'threshold_quantity' => 5,
        ]);
    }
}
