<?php

namespace App\Http\Resources\CDTCode;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CdtCodeListCollectionResource extends ResourceCollection
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'list' => CdtCodeResource::collection($this->collection)
        ];
    }
}
