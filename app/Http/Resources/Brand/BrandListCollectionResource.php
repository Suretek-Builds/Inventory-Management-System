<?php

namespace App\Http\Resources\Brand;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

class BrandListCollectionResource extends ResourceCollection
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'list' => BrandResource::collection($this->collection)
        ];
    }
}
