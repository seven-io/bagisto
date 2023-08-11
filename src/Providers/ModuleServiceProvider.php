<?php

namespace Seven\Bagisto\Providers;

use Seven\Bagisto\Models\Sms;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider {
    protected $models = [
        Sms::class,
    ];
}
