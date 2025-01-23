<?php

namespace App\Services;

use App\Data\Item\CreateItemData;
use App\Models\Item;
use App\Data\Item\UpdateItemData;
use App\Repositories\ItemRepository;
use Illuminate\Database\Eloquent\Collection;

class ItemService
{
    public function getItemsList(): Collection
    {
        /** @var ItemRepository $itemRepository */
        $itemRepository = app(ItemRepository::class);
        return $itemRepository->getItems();
    }

    public function createItem(CreateItemData $createItemData): Item
    {
        return Item::query()->create([
            'name' => $createItemData->name,
            'brand_id' => $createItemData->brand_id,
            'threshold_quantity' => $createItemData->threshold_quantity,
            'description' => $createItemData->description,
        ]);
    }

    public function updateItem(UpdateItemData $updateItemData, Item $item): Item
    {
        $item->name = $updateItemData->name;
        $item->brand_id = $updateItemData->brand_id;
        $item->threshold_quantity = $updateItemData->threshold_quantity;
        $item->description = $updateItemData->description;
        $item->save();
        return $item->refresh();
    }

    public function deleteItem(Item $brand): void
    {
        $brand->delete();
    }
}
