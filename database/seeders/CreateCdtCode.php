<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CdtCode;

class CreateCdtCode extends Seeder
{
    public function run(): void
    {
        CdtCode::query()->create([
            'name' => 'D0120',
            'description' => 'Periodic oral evaluation',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D0150',
            'description' => 'Comprehensive oral evaluation',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D1110',
            'description' => 'Prophylaxis - adult',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D0210',
            'description' => 'Intraoral - complete series of radiographic images',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D0220',
            'description' => 'Intraoral - periapical first radiographic image',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D0230',
            'description' => 'Intraoral - periapical each additional radiographic image',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D0274',
            'description' => 'Bitewings - four radiographic images',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D0330',
            'description' => 'Panoramic radiographic image',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D1206',
            'description' => 'Topical application of fluoride varnish',
            'is_active' => true,
        ]);
        CdtCode::query()->create([
            'name' => 'D3310',
            'description' => 'Endodontic therapy, anterior tooth (excluding final restoration)',
            'is_active' => true,
        ]);
    }
}
