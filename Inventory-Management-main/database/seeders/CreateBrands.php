<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class CreateBrands extends Seeder
{
    public function run(): void
    {
        Brand::query()->create([
            'name' => 'Lidocaine ABC',
            'description' => 'Lidocaine is a local anesthetic and antiarrhythmic.',
        ]);
        Brand::query()->create([
            'name' => 'Lidocaine DEF',
            'description' => 'Use for cleaning',
        ]);
        Brand::query()->create([
            'name' => 'Lidocaine GHI',
            'description' => 'Lorem Ipsum simple dummy content.',
        ]);
        Brand::query()->create([
            'name' => 'Lidocaine JKL',
            'description' => 'Lidocaine JKL description.',
        ]);
    }
}
