<?php

namespace App\Http\Resources\ProcedureTemplate;

use App\Http\Resources\CDTCode\CdtCodeResource;
use App\Models\ProcedureTemplate;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcedureTemplateResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var ProcedureTemplate $procedureTemplate */
        $procedureTemplate = $this->resource;

        return [
            'id' => $procedureTemplate->id,
            'name' => $procedureTemplate->name,
            'description' => $procedureTemplate->description,
            'is_active' => $procedureTemplate->is_active,
            'created_at' => $procedureTemplate->created_at->toDateTimeString(),
            'cdt_code' => $this->whenLoaded('cdtCode', fn () => CdtCodeResource::make($procedureTemplate->cdtCode)),
            'templateItems' => $this->whenLoaded(
                'templateItems',
                fn () => ProcedureTemplateItemResource::collection($procedureTemplate->templateItems)
            ),
        ];
    }
}
