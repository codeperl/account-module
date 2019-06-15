# account-module for laravel
User account management along with acl. A modular driven approach for laravel 5.8.

## Pre installation
* In composer.json file append:
```javascript
"module-dir": "Modules"
```
to extra section. 

* and 

```javascript
    "autoload": {
        "psr-4": {
            ....,
            "Modules\\": "Modules/",
        },
        ...
    },
```

It will be the location where laravel module will took place.

## Installation
Run

```composer require nwidart/laravel-modules```
```composer require joshbrw/laravel-module-installer```
```composer require spatie/laravel-permission```
```composer require codeperl/account```

## Post installation
* Add 
```
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
'acl' => \Modules\Account\Middlewares\AclMiddleware::class,
```

   to $routeMiddleware in App\Http\Kernel.php

   
* Run ```php artisan module:publish-config Account```

* Run ```php artisan module:publish-migration Account```

* Run ```php artisan migrate --env=development```

Done!