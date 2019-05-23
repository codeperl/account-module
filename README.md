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
```'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
   'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,```

   to $routeMiddleware in App\Http\Kernel.php.
   
2. Run ```php artisan migrate --env=development```

3. Run ```php artisan make:seeder RoleTableSeeder```

4. Update appropriate data to RoleTableSeeder class.

5. Run ```php artisan make:seeder PermissionTableSeeder```

6. Update appropriate data to PermissionTableSeeder class.

7. Run ```php artisan db:seed --class RoleTableSeeder --env=development```

8. Run ```php artisan db:seed --class PermissionTableSeeder --env=development```

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
