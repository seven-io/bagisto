<?php

namespace Seven\Bagisto\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Seven\Bagisto\Services\Configuration;
use Seven\Bagisto\View\Components\CustomerGroups;
use Seven\Bagisto\View\Components\Sms\Flash;
use Seven\Bagisto\View\Components\Sms\From;
use Seven\Bagisto\View\Components\Sms\PerformanceTracking;
use Seven\Bagisto\View\Components\Sms\Text;
use Webkul\Theme\ViewRenderEventManager;

class SevenServiceProvider extends ServiceProvider {
    public function boot(Configuration $configuration): void {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin-routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'seven');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'seven');
        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('seven/build'),
        ], 'public');

        Event::listen('admin.layout.head.before', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('seven::style');
        });
        Event::listen('bagisto.admin.customers.customers.view.card.notes.after',
            function (ViewRenderEventManager $viewRenderEventManager) {
                $viewRenderEventManager->addTemplate('seven::customer.view');
            });

        if (!empty($configuration->getAfterRegistrationText())) {
            Event::listen('customer.registration.after', 'Seven\Bagisto\Listeners\CustomerListener@afterRegistration');
        }
        if (!empty($configuration->getAfterPasswordUpdateText())) {
            Event::listen(
                'customer.password.update.after', 'Seven\Bagisto\Listeners\CustomerListener@afterPasswordUpdate'
            );
        }
        if (!empty($configuration->getAfterSaveOrderText())) {
            Event::listen('checkout.order.save.after', 'Seven\Bagisto\Listeners\CheckoutListener@afterSaveOrder');
        }
        if (!empty($configuration->getAfterSaveShipmentText())) {
            Event::listen('sales.shipment.save.after', 'Seven\Bagisto\Listeners\SalesListener@afterSaveShipment');
        }
        if (!empty($configuration->getAfterSaveRefundText())) {
            Event::listen('sales.refund.save.after', 'Seven\Bagisto\Listeners\SalesListener@afterSaveRefund');
        }

        Blade::component('seven-sms-from', From::class);
        Blade::component('seven-sms-flash', Flash::class);
        Blade::component('seven-sms-performance-tracking', PerformanceTracking::class);
        Blade::component('seven-sms-text', Text::class);
        Blade::component('seven-customer-groups', CustomerGroups::class);
    }

    public function register(): void {
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/system.php', 'core');
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/bagisto-vite.php',
            'bagisto-vite.viters'
        );
    }
}
