<?php

namespace App\Services;

use App\Data\Brand\CreateBrandData;
use App\Data\Brand\UpdateBrandData;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Database\Eloquent\Collection;

class BrandService
{
    public function getList(): Collection
    {
        /** @var BrandRepository $brandRepository */
        $brandRepository = app(BrandRepository::class);
        return $brandRepository->getBrands();
    }

    public function createBrand(CreateBrandData $createBrandData): Brand
    {
        return Brand::query()->create([
            'name' => $createBrandData->name,
            'description' => $createBrandData->description,
        ]);
    }

    public function updateBrand(UpdateBrandData $updateBrandData, Brand $brand): Brand
    {
        $brand->name = $updateBrandData->name;
        $brand->description = $updateBrandData->description;
        $brand->save();
        return $brand->refresh();
    }

    public function deleteBrand(Brand $brand): void
    {
        $brand->delete();
    }
}
