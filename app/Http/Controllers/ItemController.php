<?php

namespace App\Http\Controllers;

use App\Data\Item\CreateItemData;
use App\Models\Item;
use App\Data\Item\UpdateItemData;
use App\Http\Resources\Item\ItemListCollectionResource;
use App\Http\Resources\Item\ItemResource;
use App\Services\ItemService;
use Illuminate\Http\JsonResponse;
use App\Repositories\ItemRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ItemController extends Controller
{
    public function __construct(
        private readonly ItemService $itemService,
        private readonly ItemRepository $itemRepository
    ) {
    }

    public function getList(): ItemListCollectionResource
    {
        $itemsList = $this->itemService->getItemsList();
        return ItemListCollectionResource::make($itemsList)
            ->additional(['status' => 'success']);
    }

    public function create(CreateItemData $createItemData): ItemResource
    {
        $existingItem = $this->itemRepository->findByName($createItemData->name);
        if ($existingItem) {
            return ItemResource::make($existingItem)
            ->additional(['status' => 'error']);
        }
        $response = $this->itemService->createItem($createItemData);
        return ItemResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function update(UpdateItemData $data, int $id): ItemResource
    {
        $cdtCode = Item::query()->findOrFail($id);
        if ($cdtCode == null) {
            throw new NotFoundHttpException();
        }
        $response = $this->itemService->updateItem($data, $cdtCode);
        return ItemResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function delete(int $id): JsonResponse
    {
        $brand = $this->itemRepository->getItemById($id);
        $this->itemService->deleteItem($brand);
        return response()->json([
            'status' => 'success',
            'message' => 'CDT Code deleted'
        ]);
    }
}
