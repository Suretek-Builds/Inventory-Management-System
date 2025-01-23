<?php

namespace App\Services;

use App\Data\ItemInventory\CreateItemInventoryData;
use App\Data\Procedure\CreateProcedureData;
use App\Data\Procedure\UpdateProcedureData;
use App\Enums\InventoryTypeEnum;
use App\Models\ItemInventory;
use App\Models\Procedure;
use App\Models\ProcedureDetail;
use App\Repositories\ProcedureDetailRepository;
use App\Repositories\ProcedureRepository;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Illuminate\Support\Facades\DB;

class ProcedureService
{
    public function getList(): Collection
    {
        /** @var ProcedureRepository $procedureRepository */
        $procedureRepository = app(ProcedureRepository::class);
        return $procedureRepository->getList();
    }

    public function create(CreateProcedureData $createProcedureData): Procedure
    {
        try {
            /** @var ItemInventoryService $itemInventoryService */
            $itemInventoryService = app(ItemInventoryService::class);

            DB::beginTransaction();
            $procedure = Procedure::query()->create([
                'patient_name' => $createProcedureData->patientName,
                'patient_email' => $createProcedureData->patientEmail,
                'gender' => $createProcedureData->gender,
                'age' => $createProcedureData->age,
                'phone_number' => $createProcedureData->phoneNumber,
                'procedure_date' => $createProcedureData->procedureDate,
                'cdt_code_id' => $createProcedureData->cdtCodeId,
                'procedure_template_id' => $createProcedureData->procedureTemplateId,
            ]);

            foreach ($createProcedureData->procedureItems as $procedureItem) {
                ProcedureDetail::query()->create([
                    'procedure_id' => $procedure->id,
                    'item_id' => $procedureItem->itemId,
                    'quantity' => $procedureItem->quantity,
                ]);

                $itemInventoryService->create(new CreateItemInventoryData(
                    itemId: $procedureItem->itemId,
                    batchId: null,
                    quantity: $procedureItem->quantity,
                    expireDate: null,
                    type: InventoryTypeEnum::DEDUCTED_FOR_PROCEDURE->value,
                    procedureId: $procedure->id,
                    description: 'Deducted for booked procedure ' . $procedure->id
                ));
            }

            DB::commit();
            return $procedure;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update(UpdateProcedureData $updateProcedureData, int $id): Procedure
    {
        try {
            DB::beginTransaction();
            /** @var ProcedureRepository $procedureRepository */
            $procedureRepository = app(ProcedureRepository::class);
            $procedure = $procedureRepository->getByIdAndUpcoming($id, date('Y-m-d'));

            if ($procedure == null) {
                throw new Exception('Procedure not found or already held.');
            }

            $procedure->update([
                'patient_name' => $updateProcedureData->patientName,
                'patient_email' => $updateProcedureData->patientEmail,
                'gender' => $updateProcedureData->gender,
                'age' => $updateProcedureData->age,
                'phone_number' => $updateProcedureData->phoneNumber,
                'procedure_date' => $updateProcedureData->procedureDate,
                'cdt_code_id' => $updateProcedureData->cdtCodeId,
                'procedure_template_id' => $updateProcedureData->procedureTemplateId,
            ]);

            ItemInventory::query()->where([
                'procedure_id' => $procedure->id,
            ])->forceDelete();

            foreach ($updateProcedureData->procedureItems as $procedureItem) {
                ProcedureDetail::query()->updateOrCreate([
                    'procedure_id' => $procedure->id,
                    'item_id' => $procedureItem->itemId,
                ], [
                    'procedure_id' => $procedure->id,
                    'item_id' => $procedureItem->itemId,
                    'quantity' => $procedureItem->quantity,
                ]);
            }
            DB::commit();
            return $procedure;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        try {
            DB::beginTransaction();

            /** @var ProcedureRepository $procedureRepository */
            $procedureRepository = app(ProcedureRepository::class);
            $procedure = $procedureRepository->getById($id);

            if ($procedure == null) {
                throw new Exception('Procedure not found');
            }

            $procedure->delete();

            /** @var ProcedureDetailRepository $procedureDetailRepository */
            $procedureDetailRepository = app(ProcedureDetailRepository::class);
            $procedureDetail = $procedureDetailRepository->getByProcedureId($id);

            foreach ($procedureDetail as $procedureDetailItem) {
                /** @var ItemInventoryService $itemInventoryService */
                $itemInventoryService = app(ItemInventoryService::class);

                /** @var ProcedureDetail $procedureDetailItem */
                $itemInventoryService->create(new CreateItemInventoryData(
                    itemId: $procedureDetailItem->item_id,
                    batchId: null,
                    quantity: $procedureDetailItem->quantity,
                    expireDate: null,
                    type: InventoryTypeEnum::ADJUSTED_PROCEDURE->value,
                    procedureId: $id,
                    description: 'Adjusted quantity for canceling procedure ' . $procedureDetailItem->id,
                ));

                $procedureDetailItem->delete();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
