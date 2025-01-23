<?php

namespace App\Http\Resources\Item;

use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\Inventory\InventoryResource;
use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Item $item */
        $item = $this->resource;

        return [
            'id'   => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'brand_id' => $item->brand_id,
            'brand' => $this->whenLoaded('brand', fn () => BrandResource::make($item->brand)),
            'threshold_quantity' => $item->threshold_quantity,
            'total_stock_quantity' => $item->totalStockQuantity,
            'created_at' => $item->created_at->toDateString(),
            'inventories' => $this->whenLoaded(
                'inventories',
                fn () => InventoryResource::collection($item->inventories)
            ),
        ];
    }
}
