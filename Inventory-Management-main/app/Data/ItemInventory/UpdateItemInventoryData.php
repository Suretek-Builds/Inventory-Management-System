<?php

namespace App\Data\ItemInventory;

use Spatie\LaravelData\Data;

class UpdateItemInventoryData extends Data
{
    public function __construct(
        public readonly int $quantity,
    ) {
    }
}
