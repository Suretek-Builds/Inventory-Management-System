<?php

namespace App\Http\Controllers;

use App\Data\Procedure\CreateProcedureData;
use App\Data\Procedure\UpdateProcedureData;
use App\Http\Resources\Procedure\ProcedureListCollectionResource;
use App\Http\Resources\Procedure\ProcedureResource;
use App\Services\ProcedureService;
use Exception;
use Illuminate\Http\JsonResponse;

class ProcedureController extends Controller
{
    public function __construct(private readonly ProcedureService $procedureService)
    {
    }

    public function getList(): ProcedureListCollectionResource
    {
        $response = $this->procedureService->getList();
        return ProcedureListCollectionResource::make($response)
            ->additional(['status' => 'success']);
    }

    /**
     * @param CreateProcedureData $createProcedureData
     * @return ProcedureResource
     * @throws Exception
     */
    public function create(CreateProcedureData $createProcedureData): ProcedureResource
    {
        $response = $this->procedureService->create($createProcedureData);
        return ProcedureResource::make($response)
            ->additional(['status' => 'success']);
    }

    /**
     * @param UpdateProcedureData $updateProcedureData
     * @param int $id
     * @return ProcedureResource
     * @throws Exception
     */
    public function update(UpdateProcedureData $updateProcedureData, int $id): ProcedureResource
    {
        $response = $this->procedureService->update($updateProcedureData, $id);
        return ProcedureResource::make($response)
            ->additional(['status' => 'success']);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(int $id): JsonResponse
    {
        $this->procedureService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Procedure deleted'
        ]);
    }
}
