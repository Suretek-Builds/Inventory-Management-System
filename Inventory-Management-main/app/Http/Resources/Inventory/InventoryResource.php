<?php

namespace App\Http\Resources\Inventory;

use App\Http\Resources\Item\ItemResource;
use App\Models\ItemInventory;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var ItemInventory $inventory */
        $inventory = $this->resource;

        $item = collect();

        if ($inventory->relationLoaded('item')) {
            $item = $inventory->loadMissing('item');
        } elseif ($inventory->relationLoaded('trashedItem')) {
            $item = $inventory->loadMissing('trashedItem');
        }

        return [
            'id' => $inventory->id,
            'item_id' => $inventory->item_id,
            'type' => $inventory->type,
            'procedure_id' => $inventory->procedure_id,
            'description' => $inventory->description,
            'batch_id' => $inventory->batch_id,
            'created_at' => $inventory->created_at->toDateTimeString(),
            'expire_at' => $inventory->expire_at,
            'quantity' => $inventory->quantity,
            'item' => $item->isNotEmpty() ? ItemResource::make($item) : null,
        ];
    }
}
