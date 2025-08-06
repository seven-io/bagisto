<?php

namespace Seven\Bagisto\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Seven\Bagisto\View\Components\Sms\From;

class SevenServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     * @return void
     */
    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin-routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'seven');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'seven');

        Event::listen('bagisto.admin.customers.customers.view.card.notes.after', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('seven::customer_view');
        });

        Event::listen('customer.registration.after', 'Seven\Bagisto\Listeners\CustomerListener@afterRegistration');
        Event::listen('customer.password.update.after', 'Seven\Bagisto\Listeners\CustomerListener@afterPasswordUpdate');
        Event::listen('checkout.order.save.after', 'Seven\Bagisto\Listeners\CheckoutListener@afterSaveOrder');

        Blade::component('sms-from', From::class);
    }

    /**
     * Register services.
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/system.php', 'core');
    }
}
