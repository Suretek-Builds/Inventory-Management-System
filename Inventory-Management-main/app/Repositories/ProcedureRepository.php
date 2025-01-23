<?php

namespace App\Repositories;

use App\Models\Procedure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProcedureRepository
{
    public function getList(): Collection
    {
        return Procedure::query()
            ->with([
                'procedureDetail',
                'procedureDetail.item',
                'procedureDetail.item.brand',
                'cdtCode',
                'procedureTemplate',
                'procedureTemplate.templateItems',
            ])->get();
    }

    public function getTodayProceduresCount(string $date): int
    {
        return Procedure::query()
            ->whereDate('procedure_date', $date)
            ->count();
    }

    public function getTotalProcedureCount(): int
    {
        return Procedure::query()->count();
    }

    public function upcomingProceduresDetails(string $date): \Illuminate\Support\Collection
    {
        return DB::table('procedures')
            ->whereRaw('procedure_date >= NOW()')
            ->orderBy('procedure_date')
            ->get();
    }

    public function getById(int $id): ?Procedure
    {
        return Procedure::query()->where('id', $id)->first();
    }

    public function getByIdAndUpcoming(int $id, string $date): ?Procedure
    {
        return Procedure::query()
            ->where('id', $id)
            ->whereDate('procedure_date', '>=', $date)
            ->first();
    }
}
