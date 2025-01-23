<?php

namespace App\Http\Resources\Inventory;

use App\Http\Resources\Item\ItemResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InventoryListCollectionResource extends ResourceCollection
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'list' => ItemResource::collection($this->collection),
        ];
    }
}
