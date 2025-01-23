<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcedureTemplate;
use App\Models\CdtCode;

class CreateProcedureTemplate extends Seeder
{
    public function run(): void
    {
        ProcedureTemplate::query()->create([
            'name' => 'Root Canal Treatment',
            'cdt_code_id' =>  CdtCode::query()->inRandomOrder()->first()->id,
            'description' => 'Canal Surgery',
            'is_active' => true,
        ]);
        ProcedureTemplate::query()->create([
            'name' => 'Main Canal Treatment',
            'cdt_code_id' =>  CdtCode::query()->inRandomOrder()->first()->id,
            'description' => 'Main Canal Surgery',
            'is_active' => true,
        ]);
    }
}
