<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Managers\ResourcesManager;


class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $wildCardDirectoryPath = base_path().DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers';
        $resourceManager = new ResourcesManager();
        $resources = $resourceManager->findResources($wildCardDirectoryPath);

        dd($resources);
        return view('account::resource.index');
    }
}
