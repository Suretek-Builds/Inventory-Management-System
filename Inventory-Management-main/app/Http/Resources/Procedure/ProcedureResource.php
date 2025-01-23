<?php

namespace App\Http\Resources\Procedure;

use App\Http\Resources\CDTCode\CdtCodeResource;
use App\Http\Resources\ProcedureTemplate\ProcedureTemplateResource;
use App\Models\Procedure;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcedureResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Procedure $procedure */
        $procedure = $this->resource;

        return [
            'id' => $procedure->id,
            'patient_name' => $procedure->patient_name,
            'patient_email' => $procedure->patient_email,
            'gender' => $procedure->gender,
            'age' => $procedure->age,
            'phone_number' => $procedure->phone_number,
            'procedure_date' => $procedure->procedure_date,
            'cdt_code' => $this->whenLoaded('cdtCode', fn() => CdtCodeResource::make($procedure->cdtCode)),
            'cdt_code_id' => $procedure->cdt_code_id,
            'procedure_template_id' => $procedure->procedure_template_id,
            'template' => $this->whenLoaded(
                'procedureTemplate',
                fn() => ProcedureTemplateResource::make($procedure->procedureTemplate)
            ),
            'created_at' => $procedure->created_at->toDateTimeString(),
        ];
    }
}
