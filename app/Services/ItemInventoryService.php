<?php

namespace App\Services;

use App\Data\ItemInventory\CreateItemInventoryData;
use App\Data\ItemInventory\RestockData;
use App\Data\ItemInventory\UpdateItemInventoryData;
use App\Enums\InventoryTypeEnum;
use App\Models\ItemInventory;
use App\Repositories\ItemInventoryRepository;
use App\Repositories\ItemRepository;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ItemInventoryService
{
    public function getList(): Collection
    {
        /** @var ItemInventoryRepository $itemInventoryRepository */
        $itemInventoryRepository = app(ItemInventoryRepository::class);
        return $itemInventoryRepository->getItemInventories();
    }

    public function create(CreateItemInventoryData $data): ItemInventory
    {
        return ItemInventory::query()->create([
            'item_id' => $data->itemId,
            'type' => $data->type,
            'description' => $data->description,
            'procedure_id' => $data->procedureId,
            'quantity' => $data->quantity,
            'batch_id' => $data->batchId,
            'expire_at' => $data->expireDate,
        ]);
    }

    public function update(UpdateItemInventoryData $updateItemInventoryData, int $id): void
    {
        ItemInventory::query()->where('id', $id)->update([
            'quantity' => $updateItemInventoryData->quantity,
        ]);
    }

    public function delete(int $id): void
    {
    }

    public function restockItems(RestockData $data): void
    {
        try {
            DB::beginTransaction();

            /** @var ItemRepository $itemRepository */
            $itemRepository = app(ItemRepository::class);

            if ($data->type === 'all') {
                $items = $itemRepository->getItems()->pluck('id');
            } else {
                $items = $itemRepository->getLowStockItems()->pluck('id');
            }

            foreach ($items as $itemId) {
                $this->create(new CreateItemInventoryData(
                    itemId: $itemId,
                    batchId: 'BATCH-' . random_int(1000, 9999),
                    quantity: 100,
                    expireDate: Carbon::now()->addDays(100),
                    type: InventoryTypeEnum::ADDED->value,
                    procedureId: null,
                    description: 'Added inventory through restock.  '
                ));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
