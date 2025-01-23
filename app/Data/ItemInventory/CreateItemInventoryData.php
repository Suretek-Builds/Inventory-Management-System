<?php

namespace App\Data\ItemInventory;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class CreateItemInventoryData extends Data
{
    public function __construct(
        public readonly int $itemId,
        public readonly ?string $batchId,
        public readonly int $quantity,
        public readonly ?Carbon $expireDate,
        public readonly string $type,
        public readonly ?int $procedureId,
        public readonly ?string $description,
    ) {
    }
}
