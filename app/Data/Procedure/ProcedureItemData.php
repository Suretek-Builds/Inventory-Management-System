<?php

namespace App\Data\Procedure;

use Spatie\LaravelData\Data;

class ProcedureItemData extends Data
{
    public function __construct(
        public readonly int $itemId,
        public readonly int $quantity,
    ) {
    }
}
