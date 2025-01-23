<?php

namespace App\Http\Controllers;

use App\Data\CdtCode\CreateCdtCodeData;
use App\Data\CdtCode\GetCdtCodesListData;
use App\Data\CdtCode\UpdateCdtCodeData;
use App\Http\Resources\CDTCode\CdtCodeListCollectionResource;
use App\Http\Resources\CDTCode\CdtCodeResource;
use App\Models\CdtCode;
use App\Services\CdtCodeService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repositories\CdtCodeRepository;
use Illuminate\Http\JsonResponse;

class CdtCodeController extends Controller
{
    public function __construct(
        private readonly CdtCodeService $cdtCodeService,
        private readonly CdtCodeRepository $cdtCodeRepository
    ) {
    }

    public function getList(GetCdtCodesListData $getCdtCodesListData): CdtCodeListCollectionResource
    {
        $type = $getCdtCodesListData->type;
        $cdtCodeList = $this->cdtCodeService->getList($type);
        return CdtCodeListCollectionResource::make($cdtCodeList)
            ->additional(['status' => 'success']);
    }

    public function create(CreateCdtCodeData $data): CdtCodeResource
    {
        $existingCdtCode = $this->cdtCodeRepository->findByName($data->name);
        if ($existingCdtCode) {
            return CdtCodeResource::make($existingCdtCode)
            ->additional(['status' => 'error']);
        }
        $response = $this->cdtCodeService->createCdtCode($data);
        return CdtCodeResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function update(UpdateCdtCodeData $data, int $id): CdtCodeResource
    {
        $cdtCode = CdtCode::query()->findOrFail($id);
        if ($cdtCode == null) {
            throw new NotFoundHttpException();
        }
        $response = $this->cdtCodeService->updateCdtCode($data, $cdtCode);
        return CdtCodeResource::make($response)
            ->additional(['status' => 'success']);
    }

    public function delete(int $id): JsonResponse
    {
        $brand = $this->cdtCodeRepository->getCdtCodeById($id);
        $this->cdtCodeService->deleteCdtCode($brand);
        return response()->json([
            'status' => 'success',
            'message' => 'CDT Code deleted'
        ]);
    }
}
