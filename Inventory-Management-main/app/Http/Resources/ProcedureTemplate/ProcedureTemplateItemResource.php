<?php

namespace App\Http\Resources\ProcedureTemplate;

use App\Http\Resources\Item\ItemResource;
use App\Models\ProcedureTemplateItem;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcedureTemplateItemResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var ProcedureTemplateItem $procedureTemplateItem */
        $procedureTemplateItem = $this->resource;

        return [
            'id' => $procedureTemplateItem->id,
            'quantity' => $procedureTemplateItem->quantity,
            'item' => $this->whenLoaded('item', fn () => ItemResource::make($procedureTemplateItem->item)),
            'procedure_template_id' => $procedureTemplateItem->procedure_template_id,
            'item_id' => $procedureTemplateItem->item_id,
            'procedureTemplate' => $this->whenLoaded(
                'procedureTemplate',
                fn () => ProcedureTemplateResource::make($procedureTemplateItem->procedureTemplate)
            ),
        ];
    }
}
