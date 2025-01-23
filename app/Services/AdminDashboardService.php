<?php

namespace App\Services;

use App\Repositories\CdtCodeRepository;
use App\Repositories\ProcedureRepository;
use App\Repositories\ItemRepository;
use App\Repositories\ItemInventoryRepository;
use App\Repositories\ProcedureDetailRepository;

class AdminDashboardService
{
    /**
     * @return array<string, mixed>
     */
    public function getDashboardData(): array
    {
        /** @var ProcedureRepository $procedureRepository */
        $procedureRepository = app(ProcedureRepository::class);
        $date = date('Y-m-d');
        $todayProceduresCount = $procedureRepository->getTodayProceduresCount($date);
        $totalProceduresCount = $procedureRepository->getTotalProcedureCount();
        $upcomingProcedureDetails = $procedureRepository->upcomingProceduresDetails($date);

        /** @var ItemRepository $itemRepository */
        $itemRepository = app(ItemRepository::class);
        $totalItems = $itemRepository->getTotalItems();

        /** @var ItemInventoryRepository $itemRepository */
        $inventoryRepository = app(ItemInventoryRepository::class);
        $getLowStockItems = $inventoryRepository->getLowStockItemsList();

        /** @var ProcedureDetailRepository $itemRepository */
        $procedureDetailRepository = app(ProcedureDetailRepository::class);
        $getMostUsedItems = $procedureDetailRepository->getMostUsedItems();

        /** @var CdtCodeRepository $cdtCodeRepository */
        $cdtCodeRepository = app(CdtCodeRepository::class);
        $unmappedCdtCodesCount = $cdtCodeRepository->getUnmappedCdtCodesCount();


        return [
            'todayAppointmentCount' => $todayProceduresCount,
            'totalAppointment' => $totalProceduresCount,
            'totalItems' => $totalItems,
            'newAppointment' => $upcomingProcedureDetails,
            'getLowStockItems' => $getLowStockItems,
            'getMostUsedItems' => $getMostUsedItems,
            'unmappedCdtCodesCount' => $unmappedCdtCodesCount,
        ];
    }
}
