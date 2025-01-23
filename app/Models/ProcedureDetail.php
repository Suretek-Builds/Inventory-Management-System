<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @class ProcedureDetail
 * @package App\Models
 *
 * @property int $id
 * @property int $procedure_id
 * @property int $item_id
 * @property int $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property-read Procedure $procedure
 * @property-read Item $item
 */
class ProcedureDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
