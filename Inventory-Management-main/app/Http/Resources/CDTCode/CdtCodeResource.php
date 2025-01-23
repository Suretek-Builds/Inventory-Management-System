<?php

namespace App\Http\Resources\CDTCode;

use App\Http\Resources\ProcedureTemplate\ProcedureTemplateResource;
use App\Models\CdtCode;
use Illuminate\Http\Resources\Json\JsonResource;

class CdtCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var CdtCode $cdtCode */
        $cdtCode = $this->resource;

        return [
            'id'   => $cdtCode->id,
            'name' => $cdtCode->name,
            'description' => $cdtCode->description,
            'is_active' => $cdtCode->is_active,
            'created_at' => $cdtCode->created_at->toDateString(),
            'procedure_templates_count' => $cdtCode->proceduresTemplateCountAttribute,
            'procedure_templates' => $this->whenLoaded(
                'procedureTemplates',
                fn () => ProcedureTemplateResource::collection($cdtCode->procedureTemplates)
            ),
        ];
    }
}
