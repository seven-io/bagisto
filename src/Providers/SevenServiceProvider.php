<?php

namespace Seven\Bagisto\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\DataGrids\Customers\CustomerDataGrid;
use Webkul\Admin\DataGrids\Customers\GroupDataGrid;
use Webkul\Theme\ViewRenderEventManager;

class SevenServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin-routes.php');

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

        Event::listen('bagisto.admin.customers.customers.view.card.notes.after', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('seven::customer_view');
        });
    }

    /**
     * Register services.
     * @return void
     */
    public function register() {
        $this->app->extend(CustomerDataGrid::class,
            function (CustomerDataGrid $service) {
/*                $service->addAction([
                    'icon' => 'icon-report',
                    'method' => 'GET',
                    'url'    => function ($row) {
                        return route('admin.seven.sms_customer', $row->customer_id);
                    },
                    'title' => trans('seven::app.send_sms'),
                ]);
                $service->addMassAction([
                    //'icon' => 'icon-envelope',
                    'method' => 'GET',
                    'url'    => function ($row) {
                        return route('admin.seven.sms_customer', $row->customer_id);
                    },
                    'title' => trans('seven::app.send_sms'),
                ]);*/
                return $service;
            });

        $this->app->extend(GroupDataGrid::class,
            function (GroupDataGrid $service) {
    /*            $service->addAction([
                    'icon' => 'icon-report',
                    'method' => 'GET',
                    'url'    => function ($row) {
                        return route('admin.seven.sms_customer_group', $row->id);
                    },
                    'title' => trans('seven::app.send_sms'),
                ]);*/
                return $service;
            });

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/system.php', 'core');
    }
}
