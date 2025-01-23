<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProcedureTemplate
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $cdt_code_id
 * @property string $description
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property-read CdtCode $cdtCode
 * @property-read Collection<int, ProcedureTemplateItem> $templateItems
 */

class ProcedureTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function cdtCode(): BelongsTo
    {
        return $this->belongsTo(CdtCode::class);
    }

    public function templateItems(): HasMany
    {
        return $this->hasMany(ProcedureTemplateItem::class);
    }
}
