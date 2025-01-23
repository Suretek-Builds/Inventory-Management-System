<?php

namespace App\Http\Resources\Procedure;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProcedureListCollectionResource extends ResourceCollection
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'list' => ProcedureResource::collection($this->collection),
        ];
    }
}
