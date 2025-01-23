<?php

namespace App\Data\Procedure;

use Spatie\LaravelData\Data;

class ProcedureTemplateItemData extends Data
{
    /**
     * @param int|null $id
     * @param int $quantity
     * @param array<int, mixed> $item
     * @param int|null $removedItem
     */
    public function __construct(
        public readonly ?int $id,
        public readonly int $quantity,
        public readonly array $item = [],
        public readonly ?int $removedItem = null,
    ) {
    }
}
