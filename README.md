# account-module for laravel
User account management along with acl. A modular driven approach for laravel 5.8.

## Pre installation
In composer.json file append:
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
composer require codeperl/account

## Post installation
1. Add 
```
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
'acl' => \Modules\Account\Http\Middleware\Acl::class,
```
to $routeMiddleware in App\Http\Kernel.php.
   
2. Run ```php artisan module:publish-config```

3. Run ```php artisan module:publish-migration```

4. Run ```php artisan migrate --env=development```

5. Developer needs to add 'web' as guard via ui or console command.

6. Developer needs to add 'public' and 'Grand all' permissions via ui or console command.

Done!
