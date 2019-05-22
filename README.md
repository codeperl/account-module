# Account
User account management along with acl. A modular driven approach for laravel 5.8.

## Installation
composer require codeperl/account

## Post installation
1. Add ```'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
   'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,```
   to $routeMiddleware in App\Http\Kernel.php.
   
2. Run ```php artisan migrate --env=development```

3. Run ```php artisan module:seed --class RoleTableSeeder --env=development```

4. Run ```php artisan module:seed --class PermissionTableSeeder --env=development```

Done!

Now you will get access of these urls:

account/login
account/register
account/routes
account/routes/create
account/routes/{id}/edit
account/routes/{id}
account/routes/{id}/destroy
