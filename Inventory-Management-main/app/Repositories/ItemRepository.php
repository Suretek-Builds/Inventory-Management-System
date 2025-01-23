<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class ItemRepository
{
    public function getItems(): Collection
    {
        return Item::query()->with(['brand'])->get();
    }

    public function getItemById(int $id): Item
    {
        return Item::query()->findOrFail($id);
    }

    public function findByName(string $name): ?Item
    {
        return Item::query()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->first();
    }

    public function getTotalItems(): int
    {
        return Item::query()->count();
    }

    public function getLowStockItems(): Collection
    {
        return Item::all()->filter(function ($item) {
            /** @var Item $item */
            return $item->total_stock_quantity < $item->threshold_quantity;
        });
    }
}
