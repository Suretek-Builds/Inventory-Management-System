<?php

namespace App\Http\Controllers;

use App\Data\ItemInventory\CreateItemInventoryData;
use App\Data\ItemInventory\RestockData;
use App\Data\ItemInventory\UpdateItemInventoryData;
use App\Http\Resources\Inventory\InventoryListCollectionResource;
use App\Services\ItemInventoryService;
use Illuminate\Http\JsonResponse;
use Exception;

class InventoryController extends Controller
{
    public function __construct(private readonly ItemInventoryService $itemInventoryService)
    {
    }

    public function getList(): InventoryListCollectionResource
    {
        $response = $this->itemInventoryService->getList();
        return InventoryListCollectionResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function create(CreateItemInventoryData $createInventoryData): void
    {
        $this->itemInventoryService->create($createInventoryData);
    }

    public function update(UpdateItemInventoryData $updateInventoryData, int $id): void
    {
        $this->itemInventoryService->update($updateInventoryData, $id);
    }

    public function delete(int $id): void
    {
        $this->itemInventoryService->delete($id);
    }

    /**
     * @param RestockData $restockData
     * @return JsonResponse
     * @throws Exception
     */
    public function restock(RestockData $restockData): JsonResponse
    {
        $this->itemInventoryService->restockItems($restockData);
        return response()->json([
           'status' => 'success',
           'message' => 'Items restocked.',
        ]);
    }
}
