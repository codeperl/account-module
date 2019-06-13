<?php

namespace Modules\Account\Managers;

use Modules\Account\Entities\PermissionHasResource;
use Modules\Account\Repositories\PermissionHasResourceRepository;
use Modules\Account\Repositories\PermissionRepository;
use Modules\Account\Repositories\ResourceRepository;

/**
 * Class PermissionHasResourceManager
 * @package Modules\Account\Managers
 */
class PermissionHasResourceManager
{
    /** @var PermissionRepository  */
    private $permissionRepository;

    /** @var ResourceRepository  */
    private $resourceRepository;

    /** @var PermissionHasResourceRepository */
    private $permissionHasResourceRepository;

    /**
     * PermissionHasResourceManager constructor.
     * @param PermissionRepository $permissionRepository
     * @param ResourceRepository $resourceRepository
     * @param PermissionHasResourceRepository $permissionHasResourceRepository
     */
    public function __construct(PermissionRepository $permissionRepository, ResourceRepository $resourceRepository,
    PermissionHasResourceRepository $permissionHasResourceRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->resourceRepository = $resourceRepository;
        $this->permissionHasResourceRepository = $permissionHasResourceRepository;
    }

    /**
     * @param $column
     * @param $order
     * @param int $elementPerPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($column, $order, $elementPerPage = 20)
    {
        $select = ['permission_has_resources.permission_id AS permission_id', 'permission_has_resources.resource AS resource', 'resources.http_command AS http_command', 'resources.uri AS uri'];

        return PermissionHasResource::leftJoin('resources', 'resources.resource', '=',
                'permission_has_resources.resource')->orderBy($column, $order)->paginate($elementPerPage, $select);
    }

    /**
     * @param $permissionId
     * @param $resourceIdentity
     * @return mixed
     */
    public function unAssign($permissionId, $resourceIdentity)
    {
        return $this->permissionHasResourceRepository->delete($permissionId, $resourceIdentity);
    }
}