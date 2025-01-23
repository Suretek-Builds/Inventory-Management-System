<?php

namespace App\Data\Procedure;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class CreateProcedureTemplateData extends Data
{
    /**
     * @param string $name
     * @param string $description
     * @param int $cdt_code_id
     * @param bool $status
     * @param array<int, ProcedureTemplateItemData> $templateItems
     */
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly int $cdt_code_id,
        public readonly bool $status,
        #[DataCollectionOf(ProcedureTemplateItemData::class),]
        public readonly array $templateItems = [],
    ) {
    }
}
