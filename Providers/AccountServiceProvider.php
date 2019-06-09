<?php

namespace Modules\Account\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\View\Compilers\BladeCompiler;
use Modules\Account\Enums\Permissions;
use Modules\Account\Repositories\PermissionHasResourceRepository;
use Modules\Account\Repositories\ResourceRepository;

class AccountServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadCommands();
        $this->registerBladeExtensions();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('account.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'account'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/account');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/account';
        }, \Config::get('view.paths')), [$sourcePath]), 'account');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/account');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'account');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'account');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function loadCommands()
    {
        $this->commands([
            \Modules\Account\Console\Commands\UserCreateCommand::class,
            \Modules\Account\Console\Commands\RoleCreateCommand::class,
            \Modules\Account\Console\Commands\PermissionCreateCommand::class,
            \Modules\Account\Console\Commands\AssignPermissionToRoleCommand::class,
            \Modules\Account\Console\Commands\AssignPermissionToUserCommand::class,
            \Modules\Account\Console\Commands\AssignRoleToUserCommand::class,
            \Modules\Account\Console\Commands\AssignResourceToPermissionCommand::class
        ]);
    }

    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('acl', function ($resource) {
                if(!app('auth')->guest() && app('auth')->user()->can(Permissions::PERMIT_ALL)) {
                    return "<?php if(true): ?>";
                }

                $resource = app('router')->getRoutes()->match(app('request')->create(route($resource)))->getAction()['controller'];

                $permissionHasResourceRepository = new PermissionHasResourceRepository();
                $permissionsHasResources = $permissionHasResourceRepository->getPermissionsBy($resource);

                foreach ($permissionsHasResources as $permissionHasResource) {
                    $permission = $permissionHasResource->permission->name;
                    $permissions[] = $permission;
                    if ($status = app('auth')->user()->can($permission)) {
                        return "<?php if(true): ?>";
                    }
                }

                return "<?php if(false): ?>";
            });

            $bladeCompiler->directive('endacl', function () {
                return '<?php endif; ?>';
            });
        });
    }
}
