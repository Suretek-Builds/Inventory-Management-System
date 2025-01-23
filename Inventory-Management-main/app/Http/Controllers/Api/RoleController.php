<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $orderColumn = request('order_column', 'created_at');
        if (!in_array($orderColumn, ['id', 'name', 'created_at'])) {
            $orderColumn = 'created_at';
        }
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }
        $roles = Role::query()
            ->when(request('search_id'), static function ($query) {
                $query->where('id', request('search_id'));
            })
            ->when(request('search_title'), function ($query) {
                $query->where('name', 'like', '%' . request('search_title') . '%');
            })
            ->when(request('search_global'), function ($query) {
                $query->where(function ($q) {
                    $q->where('id', request('search_global'))
                        ->orWhere('name', 'like', '%' . request('search_global') . '%');
                });
            })
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(50);

        return RoleResource::collection($roles);
    }

    /**
     * @param StoreRoleRequest $request
     * @return RoleResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreRoleRequest $request): RoleResource|JsonResponse
    {
        $this->authorize('role-create');

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';

        if ($role->save()) {
            return new RoleResource($role);
        }

        return response()->json(['status' => 405, 'success' => false]);
    }

    /**
     * @param Role $role
     * @return RoleResource
     * @throws AuthorizationException
     */
    public function show(Role $role): RoleResource
    {
        $this->authorize('role-edit');

        return new RoleResource($role);
    }

    /**
     * @param Role $role
     * @param StoreRoleRequest $request
     * @return RoleResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(Role $role, StoreRoleRequest $request): RoleResource|JsonResponse
    {
        $this->authorize('role-edit');

        $role->name = $request->name;

        if ($role->save()) {
            return new RoleResource($role);
        }

        return response()->json(['status' => 405, 'success' => false]);
    }

    /**
     * @param Role $role
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Role $role): Response
    {
        $this->authorize('role-delete');
        $role->delete();

        return response()->noContent();
    }

    public function getList(): AnonymousResourceCollection
    {
        return RoleResource::collection(Role::all());
    }
}
