<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class CDTCode
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 *
 * @property-read ProcedureTemplate $procedureTemplates
 * @property-read int $proceduresTemplateCountAttribute
 */

class CdtCode extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'template_procedures_count'
    ];

    public function procedureTemplates(): HasMany
    {
        return $this->hasMany(ProcedureTemplate::class, 'cdt_code_id');
    }

    public function proceduresTemplateCountAttribute(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->procedureTemplates()->count();
            },
        );
    }
}
