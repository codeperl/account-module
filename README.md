# account-module for laravel
User account management along with acl. A modular driven approach for laravel 5.8.

## Pre installation
In composer.json file append:
```javascript
"module-dir": "Modules"
```
to extra section. 

and 

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
composer require nwidart/laravel-modules
composer require joshbrw/laravel-module-installer
composer require spatie/laravel-permission
composer require codeperl/account

## Post installation
1. Add 
```
'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
'acl' => \Modules\Account\Middlewares\AclMiddleware::class,
```

   to $routeMiddleware in App\Http\Kernel.php.
   
2. Run ```php artisan migrate --env=development```

Done!

Now you will get access of these urls:

```account```
```account/login```
```account/register```
```account/logout```
```account/password/email```
```account/password/reset```
```account/password/reset/{token}```
```account/roles```
```account/roles/create```
```account/roles/{id}/edit```
```account/roles/{id}```
