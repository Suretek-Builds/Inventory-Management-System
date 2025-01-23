<?php

namespace App\Models;

use App\Enums\InventoryTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Item
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $brand_id
 * @property float $threshold_quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property-read int $totalStockQuantity
 * @property-read Brand $brand
 * @property-read Collection<int, ItemInventory> $inventories
 */
class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'total_stock_quantity',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(ItemInventory::class);
    }

    public function totalStockQuantity(): Attribute
    {
        return new Attribute(
            get: function () {
                $stock = 0;

                foreach ($this->inventories as $inventory) {
                    if ($inventory->type === InventoryTypeEnum::DEDUCTED_FOR_PROCEDURE->value) {
                        $stock -= $inventory->quantity;
                    } else {
                        $stock += $inventory->quantity;
                    }
                }
                return $stock;
            },
        );
    }
}
