<?php

namespace App\Repositories;

use App\Enums\CdtCodesEnum;
use App\Models\CdtCode;
use Illuminate\Database\Eloquent\Collection;

class CdtCodeRepository
{
    /**
     * @param string $type
     * @return Collection
     */
    public function getCdtCodes(string $type = 'all'): Collection
    {
        $query = CdtCode::query()->withCount('procedureTemplates as procedureTemplatesCount');

        if ($type === CdtCodesEnum::MAPPED->value) {
            $query->whereHas('procedureTemplates')
                ->with([
                    'procedureTemplates',
                    'procedureTemplates.templateItems',
                    'procedureTemplates.templateItems.item'
                ]);
        } elseif ($type === CdtCodesEnum::UNMAPPED->value) {
            $query->whereDoesntHave('procedureTemplates');
        }
        return $query->get();
    }

    public function getUnmappedCdtCodesCount(): int
    {
        return CdtCode::query()
            ->whereDoesntHave('procedureTemplates')
            ->count();
    }

    public function getCdtCodeById(int $id): CdtCode
    {
        return CdtCode::query()->findOrFail($id);
    }

    public function findByName(string $name): ?CdtCode
    {
        return CdtCode::query()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->first();
    }
}
