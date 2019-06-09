<?php

namespace Modules\Account\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Facades\App;
use Modules\Account\Enums\Permissions;
use Modules\Account\Managers\AclManager;
use Modules\Account\Repositories\PermissionHasResourceRepository;
use Modules\Account\Repositories\PermissionRepository;

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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        App::bind('acl', function() {
            return new AclManager(new PermissionRepository(), new PermissionHasResourceRepository());

        });

        $this->registerBladeExtensions();
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
            $bladeCompiler->directive('acl', function ($arguments) {
                list($route, $params, $actionName) = explode(',', $arguments.',');

                if($actionName) {
                    return "<?php if( app('acl')->access(
                                                        app('router')->getRoutes()->match(
                                                                                            app('request')->create(
                                                                                                                    route({$route}, {$params})
                                                                                                                  )
                                                                                         )->getAction()['controller'],
                                                        app('acl')->getGuard(),
                                                        {$actionName}
                                                    )
                                ): ?>";
                } else {
                    return "<?php if( app('acl')->access(
                                                        app('router')->getRoutes()->match(
                                                                                            app('request')->create(
                                                                                                                    route({$route}, {$params})
                                                                                                                  )
                                                                                         )->getAction()['controller'],
                                                        app('acl')->getGuard()
                                                    )
                                ): ?>";
                }

            });

            $bladeCompiler->directive('endacl', function () {
                return '<?php endif; ?>';
            });
        });
    }
}
