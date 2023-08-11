<?php

namespace Seven\Bagisto\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\DataGrids\CustomerDataGrid;
use Webkul\Admin\DataGrids\CustomerGroupDataGrid;
use Webkul\Theme\ViewRenderEventManager;

class SevenServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'seven');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/seven/assets'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'seven');

        Event::listen('bagisto.admin.layout.head',
            function (ViewRenderEventManager $viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('seven::layouts.style');
            });

        $this->app->register(ModuleServiceProvider::class);
    }

    /**
     * Register services.
     * @return void
     */
    public function register() {
        $this->app->extend(CustomerDataGrid::class,
            function (CustomerDataGrid $service) {
                $service->addAction([
                    'icon' => 'icon seven-icon',
                    'method' => 'GET',
                    'route' => 'admin.seven.sms_customer',
                    'title' => trans('seven::app.send_sms'),
                ]);
                return $service;
            });

        $this->app->extend(CustomerGroupDataGrid::class,
            function (CustomerGroupDataGrid $service) {
                $service->addAction([
                    'icon' => 'icon seven-icon',
                    'method' => 'GET',
                    'route' => 'admin.seven.sms_customer_group',
                    'title' => trans('seven::app.send_sms'),
                ]);
                return $service;
            });

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/system.php', 'core');
    }
}
