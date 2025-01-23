<?php

namespace App\Data\CdtCode;

use App\Enums\CdtCodesEnum;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class GetCdtCodesListData extends Data
{
    public function __construct(
        #[In([
            CdtCodesEnum::ALL->value,
            CdtCodesEnum::MAPPED->value,
            CdtCodesEnum::UNMAPPED->value,
        ])]
        public readonly string $type,
    ) {
    }
}
