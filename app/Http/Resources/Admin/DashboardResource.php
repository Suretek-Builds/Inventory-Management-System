<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, int>
     */
    public function toArray($request): array
    {
        $response = $this->resource;

        return [
            'todayAppointmentCount' => $response['todayAppointmentCount'],
            'totalAppointment' => $response['totalAppointment'],
            'totalItems' => $response['totalItems'],
            'newAppointment' => $response['newAppointment'],
            'getLowStockItems' => $response['getLowStockItems'],
            'getMostUsedItems' => $response['getMostUsedItems'],
            'unmappedCdtCodesCount' => $response['unmappedCdtCodesCount'],
        ];
    }
}
