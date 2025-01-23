<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;
use App\Http\Resources\Admin\DashboardResource;

class AdminDashboardController extends Controller
{
    public function __construct(private readonly AdminDashboardService $adminDashboardService)
    {
    }

    public function getDashboardData(): DashboardResource
    {
        $response = $this->adminDashboardService->getDashboardData();
        return DashboardResource::make($response)
            ->additional([
                'status' => 'success',
            ]);
    }
}
