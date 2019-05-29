<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Resource;
use Modules\Account\Managers\ResourcesManager;
use DB;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $resources = Resource::paginate(20);

        return view('account::resource.index', compact('resources'))
            ->with('i', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate()
    {
        $wildCardDirectoryPath = base_path() . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers';
        $appDirectoryPath = base_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers';

        $resourceManager = new ResourcesManager();
        $resources = array_merge($resourceManager->findResources($wildCardDirectoryPath),
            $resourceManager->findResources($appDirectoryPath)
        );

        $resourceManager->sync($resources);

        return redirect()->route('resources.index')
            ->with('success', 'Resource generated successfully');
    }
}
