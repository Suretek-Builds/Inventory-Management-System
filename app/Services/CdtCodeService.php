<?php

namespace App\Services;

use App\Data\CdtCode\CreateCdtCodeData;
use App\Data\CdtCode\UpdateCdtCodeData;
use App\Models\CdtCode;
use App\Repositories\CdtCodeRepository;
use Illuminate\Database\Eloquent\Collection;

class CdtCodeService
{
    /**
     * @param string $type
     * @return Collection
     */
    public function getList(string $type = 'all'): Collection
    {
        /** @var CdtCodeRepository $cdtCodeRepository */
        $cdtCodeRepository = app(CdtCodeRepository::class);
        return $cdtCodeRepository->getCdtCodes($type);
    }

    public function createCdtCode(CreateCdtCodeData $createCdtCodeData): CdtCode
    {
        return CdtCode::query()->create([
            'name' => $createCdtCodeData->name,
            'description' => $createCdtCodeData->description,
            'is_active' => $createCdtCodeData->status,
        ]);
    }

    public function updateCdtCode(UpdateCdtCodeData $updateCdtCodeData, CdtCode $cdtCode): CdtCode
    {
        $cdtCode->name = $updateCdtCodeData->name;
        $cdtCode->description = $updateCdtCodeData->description;
        $cdtCode->is_active = $updateCdtCodeData->status;
        $cdtCode->save();
        return $cdtCode->refresh();
    }

    public function deleteCdtCode(CdtCode $brand): void
    {
        $brand->delete();
    }
}
