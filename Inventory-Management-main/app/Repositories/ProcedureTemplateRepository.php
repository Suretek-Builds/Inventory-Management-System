<?php

namespace App\Repositories;

use App\Models\ProcedureTemplate;
use Illuminate\Database\Eloquent\Collection;

class ProcedureTemplateRepository
{
    public function getProcedureTemplates(): Collection
    {
        return ProcedureTemplate::query()
            ->with(['cdtCode', 'templateItems', 'templateItems.item'])
            ->get();
    }

    public function getTemplateById(int $id): ProcedureTemplate
    {
        return ProcedureTemplate::query()->findOrFail($id);
    }

    public function findByName(string $name): ?ProcedureTemplate
    {
        return ProcedureTemplate::query()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->first();
    }
}
