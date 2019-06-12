<?php

namespace Modules\Account\Managers;

use DB;

/**
 * Class ResourcesManager
 * @package Modules\Account\Managers
 */
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

        $index = 0;
        foreach($routes as $route) {
            if(isset($route->action['controller'])) {

                $resources[$index]['resource'] = $route->action['controller'];
                $resources[$index]['http_command'] = $this->getCommand($route->methods);
                $resources[$index]['uri'] = $route->uri;
                $index++;
            }
        }

        return $resources;
    }

    /**
     * @param $methods
     * @return string
     */
    public function getCommand($methods)
    {
        if(is_array($methods)) {
            $methods = implode(', ', $methods);
        }

        return $methods;
    }
}