<?php

namespace App\Repositories;

use App\Models\ProcedureDetail;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ProcedureDetailRepository
{
    public function getByProcedureId(int $procedureId): Collection
    {
        return ProcedureDetail::query()
            ->where('procedure_id', $procedureId)
            ->get();
    }

    /**
     * @return array<string, mixed>
     */
    public function getMostUsedItems(): array
    {
        $lastWeekFinalData = ProcedureDetail::query()
            ->selectRaw(
                '
                    procedure_details.item_id,
                    MIN(items.name) as item_name,
                    SUM(procedure_details.quantity) as total_quantity'
            )
            ->where('procedure_details.created_at', '>=', Carbon::now()->subDays(7))
            ->join('items', 'procedure_details.item_id', '=', 'items.id')
            ->groupBy('item_id')
            ->orderBy('total_quantity', 'desc')
            ->take(5)->get();

        return ['last_week' => $lastWeekFinalData];
    }
}