<?php

namespace Database\Seeders;

use App\Models\ProcedureTemplate;
use App\Models\ProcedureTemplateItem;
use Illuminate\Database\Seeder;
use App\Models\Item;

class CreateProcedureTemplateItem extends Seeder
{
    public function run(): void
    {
        ProcedureTemplateItem::query()->create([
            'procedure_template_id' => ProcedureTemplate::query()->first()->id,
            'item_id' => Item::query()->first()->id,
            'quantity' => 10
        ]);
        ProcedureTemplateItem::query()->create([
            'procedure_template_id' => ProcedureTemplate::query()->skip(1)->first()->id,
            'item_id' => Item::query()->skip(1)->first()->id,
            'quantity' => 10
        ]);
    }
}
