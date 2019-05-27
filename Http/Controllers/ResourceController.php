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
    public function index()
    {
        $wildCardDirectoryPath = base_path().DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers';
        $resourceManager = new ResourcesManager();
        $resources = $resourceManager->findResources($wildCardDirectoryPath);

        DB::table('resources')->truncate();
        DB::table('resources')
            ->insert($resources);

        $resources = Resource::all();

        return view('account::resource.index', compact('resources'));
    }
}
