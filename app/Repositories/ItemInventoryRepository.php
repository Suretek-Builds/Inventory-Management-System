<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class ItemInventoryRepository
{
    public function getItemInventories(): Collection
    {
        return Item::query()
            ->with([
                'brand',
                'inventories' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])
            ->get();
    }

    public function getLowStockItemsList(): Collection
    {
        return Item::all()->filter(function ($item) {
            /** @var Item $item */
            return $item->total_stock_quantity < $item->threshold_quantity;
        })->take(10);
    }
}
