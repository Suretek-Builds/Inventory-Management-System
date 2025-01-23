<?php

namespace Database\Seeders;

use App\Enums\InventoryTypeEnum;
use App\Models\Item;
use App\Models\ItemInventory;
use Illuminate\Database\Seeder;

class CreateInventory extends Seeder
{
    public function run(): void
    {
        ItemInventory::query()->create([
            'item_id' => Item::query()->first()->id,
            'type' => InventoryTypeEnum::ADDED->value,
            'description' => 'Added inventory',
            'batch_id' => 'BATCH001',
            'quantity' => 100,
            'expire_at' => '2025-12-31 23:59:59'
        ]);
        ItemInventory::query()->create([
            'item_id' => Item::query()->skip(1)->first()->id,
            'type' => InventoryTypeEnum::ADDED->value,
            'description' => 'Added inventory',
            'batch_id' => 'BATCH002',
            'quantity' => 100,
            'expire_at' => '2025-12-30 23:59:59'
        ]);
    }
}
