<?php


namespace User\Http\Controllers\Admin;


use Illuminate\Routing\Controller;
use User\Http\Requests\Admin\CreateRoleRequest;
use User\Http\Resources\Role\RoleListResource;
use User\Services\RoleService;

class RoleController extends Controller
{
    private $role_service;
    public function __construct(RoleService $role_service)
    {
        $this->role_service = $role_service;
    }

    public function getAllRoles()
    {
        $role = $this->role_service->getAllRoles();
        return api()->success(null,RoleListResource::collection($role)->response()->getData());
    }

    public function createRole(CreateRoleRequest $request)
    {
        $role = $this->role_service->createRole($request);
        return api()->success(null,new RoleListResource($role));
    }

}
