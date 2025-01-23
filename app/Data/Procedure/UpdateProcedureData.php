<?php

namespace App\Data\Procedure;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class UpdateProcedureData extends Data
{
    /**
     * @param string $patientName
     * @param string $patientEmail
     * @param string $gender
     * @param int $age
     * @param string $phoneNumber
     * @param string $procedureDate
     * @param string $cdtCodeId
     * @param string $procedureTemplateId
     * @param array<int, ProcedureItemData> $procedureItems
     */
    public function __construct(
        public readonly string $patientName,
        public readonly string $patientEmail,
        public readonly string $gender,
        public readonly int $age,
        public readonly string $phoneNumber,
        public readonly string $procedureDate,
        public readonly string $cdtCodeId,
        public readonly string $procedureTemplateId,
        #[DataCollectionOf(ProcedureItemData::class)]
        public readonly array $procedureItems,
    ) {
    }
}
