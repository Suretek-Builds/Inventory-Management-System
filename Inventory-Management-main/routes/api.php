<?php

use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CdtCodeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ProcedureTemplateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forget.password.post');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::prefix('admin')->group(function () {
        Route::post('dashboard', [AdminDashboardController::class, 'getDashboardData']);
    });
    Route::get('role-permissions/{id}', [PermissionController::class, 'getRolePermissions']);
    Route::put('/role-permissions', [PermissionController::class, 'updateRolePermissions']);
    Route::apiResource('permissions', PermissionController::class);
    Route::get('/user', [ProfileController::class, 'user']);
    Route::put('/user', [ProfileController::class, 'update']);

    Route::prefix('list')->group(function () {
        Route::get('brands', [BrandController::class, 'getList']);
        Route::get('cdt-codes', [CdtCodeController::class, 'getList']);
        Route::get('items', [ItemController::class, 'getList']);
        Route::get('procedures', [ProcedureController::class, 'getList']);
        Route::get('procedure-templates', [ProcedureTemplateController::class, 'getList']);
        Route::get('inventory', [InventoryController::class, 'getList']);
    });

    Route::prefix('brand')->group(function () {
        Route::post('create', [BrandController::class, 'create']);
        Route::post('update/{id}', [BrandController::class, 'update']);
        Route::delete('delete/{id}', [BrandController::class, 'delete']);
    });

    Route::prefix('cdt-code')->group(function () {
        Route::post('create', [CdtCodeController::class, 'create']);
        Route::post('update/{id}', [CdtCodeController::class, 'update']);
        Route::delete('delete/{id}', [CdtCodeController::class, 'delete']);
    });

    Route::prefix('item')->group(function () {
        Route::post('create', [ItemController::class, 'create']);
        Route::post('update/{id}', [ItemController::class, 'update']);
        Route::delete('delete/{id}', [ItemController::class, 'delete']);
    });

    Route::prefix('procedure')->group(function () {
        Route::post('create', [ProcedureController::class, 'create']);
        Route::post('update/{id}', [ProcedureController::class, 'update']);
        Route::delete('delete/{id}', [ProcedureController::class, 'delete']);
    });

    Route::prefix('procedure-template')->group(function () {
        Route::post('create', [ProcedureTemplateController::class, 'create']);
        Route::post('update/{id}', [ProcedureTemplateController::class, 'update']);
        Route::delete('delete/{id}', [ProcedureTemplateController::class, 'delete']);
    });

    Route::post('restock', [InventoryController::class, 'restock']);

    Route::get('abilities', static function (Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});
