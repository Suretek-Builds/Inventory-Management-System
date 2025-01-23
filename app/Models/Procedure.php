<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @class Procedure
 * @package App\Models
 *
 * @property int $id
 * @property string $patient_name
 * @property string $patient_email
 * @property string $gender
 * @property int $age
 * @property string $phone_number
 * @property Carbon $procedure_date
 * @property int $cdt_code_id
 * @property int $procedure_template_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property-read ProcedureDetail $procedureDetail
 * @property-read CdtCode $cdtCode
 * @property-read ProcedureTemplate $procedureTemplate
 */
class Procedure extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function procedureDetail(): HasMany
    {
        return $this->hasMany(ProcedureDetail::class);
    }

    public function cdtCode(): BelongsTo
    {
        return $this->belongsTo(CdtCode::class);
    }

    public function procedureTemplate(): BelongsTo
    {
        return $this->belongsTo(ProcedureTemplate::class);
    }
}
