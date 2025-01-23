<?php

namespace App\Http\Controllers;

use App\Data\Brand\CreateBrandData;
use App\Data\Brand\UpdateBrandData;
use App\Http\Resources\Brand\BrandListCollectionResource;
use App\Http\Resources\Brand\BrandResource;
use App\Repositories\BrandRepository;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    public function __construct(
        private readonly BrandService $brandService,
        private readonly BrandRepository $brandRepository,
    ) {
    }

    public function getList(): BrandListCollectionResource
    {
        $brandsList = $this->brandService->getList();
        return BrandListCollectionResource::make($brandsList)
            ->additional(['status' => 'success']);
    }

    public function create(CreateBrandData $createBrandData): BrandResource
    {
        $existingbrand = $this->brandRepository->findByName($createBrandData->name);
        if ($existingbrand) {
            return BrandResource::make($existingbrand)
            ->additional(['status' => 'error']);
        }
        $response = $this->brandService->createBrand($createBrandData);
        return BrandResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function update(UpdateBrandData $updateBrandData, int $id): BrandResource
    {
        $brand = $this->brandRepository->getBrandById($id);
        $response = $this->brandService->updateBrand($updateBrandData, $brand);
        return BrandResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function delete(int $id): JsonResponse
    {
        $brand = $this->brandRepository->getBrandById($id);
        $this->brandService->deleteBrand($brand);
        return response()->json([
            'status' => 'success',
            'message' => 'Brand deleted'
        ]);
    }
}
