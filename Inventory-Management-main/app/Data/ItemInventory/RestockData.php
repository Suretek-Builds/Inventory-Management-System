<?php

namespace App\Data\ItemInventory;

use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class RestockData extends Data
{
    public function __construct(
        #[In(['all', 'low_stock'])]
        public readonly string $type,
    ) {
    }
}
