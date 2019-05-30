<?php

namespace Modules\Account\Managers;

use DB;

class ResourcesManager
{
    /**
     * @param $resources
     */
    public function sync($resources)
    {
        DB::table('resources')->truncate();

        DB::table('resources')
            ->insert($resources);
    }

    /**
     * @return array
     */
    public function findResources()
    {
        $routes = \Route::getRoutes()->getIterator();
        $resources = [];

        foreach($routes as $route) {
            if(isset($route->action['controller'])) {
                $resources[]['resource'] = $route->action['controller'];
            }
        }

        return $resources;
    }
}