<?php

namespace Sms77\Bagisto\Providers;

use Sms77\Bagisto\Models\Sms;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider {
    protected $models = [
        Sms::class,
    ];
}