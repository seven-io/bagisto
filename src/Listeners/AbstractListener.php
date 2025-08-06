<?php

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Seven\Bagisto\Services\Configuration;
use Seven\Bagisto\Services\Seven;
use Webkul\Customer\Models\Customer;

abstract readonly class AbstractListener {
    public function __construct(protected Configuration $configuration, protected Seven $seven) {
    }

    protected function hasPhone(Customer $customer): bool {
        $phone = $customer->getAttribute('phone');
        if (empty($phone)) {
            Log::debug('seven: phone not set for afterRegistration');
            return false;
        }

        return true;
    }
}

