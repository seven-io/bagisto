<?php

namespace Sms77\Bagisto\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\DataGrids\CustomerDataGrid;
use Webkul\Admin\DataGrids\CustomerGroupDataGrid;
use Webkul\Theme\ViewRenderEventManager;

class Sms77ServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'sms77');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/sms77/assets'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'sms77');

        Event::listen('bagisto.admin.layout.head',
            function (ViewRenderEventManager $viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('sms77::layouts.style');
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
                    'icon' => 'icon sms77-icon',
                    'method' => 'GET',
                    'route' => 'admin.sms77.sms_customer',
                    'title' => trans('sms77::app.send_sms'),
                ]);
                return $service;
            });

        $this->app->extend(CustomerGroupDataGrid::class,
            function (CustomerGroupDataGrid $service) {
                $service->addAction([
                    'icon' => 'icon sms77-icon',
                    'method' => 'GET',
                    'route' => 'admin.sms77.sms_customer_group',
                    'title' => trans('sms77::app.send_sms'),
                ]);
                return $service;
            });

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/system.php', 'core');
    }
}