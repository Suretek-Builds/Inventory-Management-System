<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProcedureTemplate\ProcedureTemplateListCollectionResource;
use App\Services\ProcedureTemplateService;
use App\Http\Resources\ProcedureTemplate\ProcedureTemplateResource;
use App\Data\Procedure\CreateProcedureTemplateData;
use App\Data\Procedure\UpdateProcedureTemplateData;
use App\Models\ProcedureTemplate;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repositories\ProcedureTemplateRepository;
use Illuminate\Http\JsonResponse;

class ProcedureTemplateController extends Controller
{
    public function __construct(
        private readonly ProcedureTemplateService $procedureTemplateService,
        private readonly ProcedureTemplateRepository $procedureTemplateRepository,
    ) {
    }

    public function getList(): ProcedureTemplateListCollectionResource
    {
        $procedureTemplatesList = $this->procedureTemplateService->getList();
        return ProcedureTemplateListCollectionResource::make($procedureTemplatesList)
            ->additional(['status' => 'success']);
    }

    public function create(CreateProcedureTemplateData $createTemplateData): ProcedureTemplateResource
    {
        $existingTemplate = $this->procedureTemplateRepository->findByName($createTemplateData->name);
        if ($existingTemplate) {
            throw new Exception('Template name already exists.');
        }
        $response = $this->procedureTemplateService->createTemplate($createTemplateData);
        return ProcedureTemplateResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function update(UpdateProcedureTemplateData $data, int $id): ProcedureTemplateResource
    {
        $templateCode = ProcedureTemplate::query()->findOrFail($id);
        if ($templateCode == null) {
            throw new NotFoundHttpException();
        }
        $response = $this->procedureTemplateService->updateTemplate($data, $templateCode);
        return ProcedureTemplateResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function delete(int $id): JsonResponse
    {
        $brand = $this->procedureTemplateRepository->getTemplateById($id);
        $this->procedureTemplateService->deleteTemplate($brand);
        return response()->json([
            'status' => 'success',
            'message' => 'Procedure Template deleted'
        ]);
    }
}
