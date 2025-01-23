<?php

namespace App\Services;

use App\Repositories\ProcedureTemplateRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Data\Procedure\CreateProcedureTemplateData;
use App\Data\Procedure\UpdateProcedureTemplateData;
use App\Models\ProcedureTemplate;
use App\Models\ProcedureTemplateItem;
use Illuminate\Support\Facades\DB;
use Exception;

class ProcedureTemplateService
{
    public function getList(): Collection
    {
        /** @var ProcedureTemplateRepository $procedureTemplateRepository */
        $procedureTemplateRepository = app(ProcedureTemplateRepository::class);
        return $procedureTemplateRepository->getProcedureTemplates();
    }

    public function createTemplate(CreateProcedureTemplateData $createTemplateData): ProcedureTemplate
    {
        try {
            DB::beginTransaction();
            $procedureTemplate = ProcedureTemplate::query()->create([
                'name' => $createTemplateData->name,
                'cdt_code_id' => $createTemplateData->cdt_code_id,
                'description' => $createTemplateData->description,
                'is_active' => $createTemplateData->status,
            ]);
            foreach ($createTemplateData->templateItems as $item) {
                /** @var ProcedureTemplateItem $item */
                ProcedureTemplateItem::query()->create([
                    'procedure_template_id' => $procedureTemplate->id,
                    'item_id' => $item->item['id'],
                    'quantity' => $item->quantity,
                ]);
            }
            DB::commit();
            return $procedureTemplate;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateTemplate(
        UpdateProcedureTemplateData $updateTemplateData,
        ProcedureTemplate $template
    ): ProcedureTemplate {
        $template->name = $updateTemplateData->name;
        $template->cdt_code_id = $updateTemplateData->cdt_code_id;
        $template->description = $updateTemplateData->description;
        $template->is_active = $updateTemplateData->status;
        $template->save();
        foreach ($updateTemplateData->templateItems as $item) {
            /** @var ProcedureTemplateItem $item */
            if (!$item->id) {
                ProcedureTemplateItem::query()->create([
                    'procedure_template_id' => $template->id,
                    'item_id' => $item->item['id'],
                    'quantity' => $item->quantity,
                ]);
            } else {
                if ($item->removedItem) {
                    $removeRecordID = ProcedureTemplateItem::query()->findOrFail($item->id);
                    if ($removeRecordID != null) {
                        $removeRecordID->delete();
                    }
                } else {
                    $existingRecord = ProcedureTemplateItem::query()->findOrFail($item->id);
                    if ($existingRecord != null) {
                        $existingRecord->item_id = $item->item['id'];
                        $existingRecord->quantity = $item->quantity;
                        $existingRecord->save();
                    }
                }
            }
        }
        return $template->refresh();
    }

    public function deleteTemplate(ProcedureTemplate $template): void
    {
        $template->delete();
    }
}
