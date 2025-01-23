<?php

namespace App\Data\Brand;

use Spatie\LaravelData\Data;

class UpdateBrandData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
    ) {
    }
}
