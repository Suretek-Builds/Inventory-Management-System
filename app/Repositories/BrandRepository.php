<?php

namespace App\Repositories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository
{
    public function getBrands(): Collection
    {
        return Brand::query()->get();
    }

    public function getBrandById(int $id): Brand
    {
        return Brand::query()->findOrFail($id);
    }

    public function findByName(string $name): ?Brand
    {
        return Brand::query()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->first();
    }
}
