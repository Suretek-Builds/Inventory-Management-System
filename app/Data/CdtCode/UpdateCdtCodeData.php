<?php

namespace App\Data\CdtCode;

use Spatie\LaravelData\Data;

class UpdateCdtCodeData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly bool $status,
    ) {
    }
}
