<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class ItemInventory
 * @package App\Models
 *
 * @property int $id
 * @property string $item_id
 * @property string $type
 * @property ?string $description
 * @property ?int $procedure_id
 * @property ?string $batch_id
 * @property float $quantity
 * @property ?Carbon $expire_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property-read Item $item
 * @property-read Item $trashedItem
 */
class ItemInventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function trashedItem(): BelongsTo
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }
}
