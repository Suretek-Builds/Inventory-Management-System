<?php

namespace App\Data\Brand;

use Spatie\LaravelData\Data;

class CreateBrandData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
    ) {
    }
}
