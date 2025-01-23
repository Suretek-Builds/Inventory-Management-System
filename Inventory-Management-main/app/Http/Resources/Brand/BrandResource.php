<?php

namespace App\Http\Resources\Brand;

use App\Models\Brand;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Brand $brand */
        $brand = $this->resource;

        return [
            'id'   => $brand->id,
            'name' => $brand->name,
            'description' => $brand->description,
            'created_at' => $brand->created_at->toDateString(),
        ];
    }
}
