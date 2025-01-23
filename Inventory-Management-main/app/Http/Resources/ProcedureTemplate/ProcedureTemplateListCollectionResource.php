<?php

namespace App\Http\Resources\ProcedureTemplate;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProcedureTemplateListCollectionResource extends ResourceCollection
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'list' => ProcedureTemplateResource::collection($this->collection),
        ];
    }
}
