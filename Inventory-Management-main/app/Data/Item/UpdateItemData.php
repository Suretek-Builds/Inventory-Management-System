<?php

namespace App\Data\Item;

use Spatie\LaravelData\Data;

class UpdateItemData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly int $brand_id,
        public readonly int $threshold_quantity,
    ) {
    }
}
