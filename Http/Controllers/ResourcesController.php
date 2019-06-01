<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\ResourcesManager;
use Modules\Account\Repositories\ResourceRepository;

/**
 * Class ResourcesController
 * @package Modules\Account\Http\Controllers
 */
class ResourcesController extends Controller
{
    /** @var ResourcesManager  */
    private $resourcesManager;

    /** @var ResourceRepository  */
    private $resourceRepository;

    /** @var int */
    private $elementsPerPage;

    public function __construct(ResourcesManager $resourcesManager, ResourceRepository $resourceRepository)
    {
        $this->resourcesManager = $resourcesManager;
        $this->resourceRepository = $resourceRepository;
        $this->elementsPerPage = 20;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $elementPerPage = $request->get('perPage', $this->elementsPerPage);
        $resources = $this->resourceRepository->paginate('resource', 'DESC', $elementPerPage);

        return view('account::resources.index', compact('resources'))
            ->with('i', ($request->input('page', 1) - 1) * $elementPerPage);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate()
    {
        $this->resourcesManager->sync($this->resourcesManager->findResources());

        return redirect()->route('resources.index')
            ->with('success', 'Resource generated successfully');
    }
}
