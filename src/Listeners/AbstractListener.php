<?php

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Seven\Bagisto\Services\Configuration;
use Seven\Bagisto\Services\Seven;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerRepository;

abstract readonly class AbstractListener {
    public function __construct(
        protected Configuration $configuration,
        protected Seven $seven,
        protected CustomerRepository $customerRepository
    ) {
    }

    protected function hasPhone(Customer $customer): bool {
        $phone = $customer->getAttribute('phone');
        if (empty($phone)) {
            $class = get_class($this);
            $fn = debug_backtrace()[1]['function'];
            $identifier = $class . '@' . $fn;
            Log::debug('seven: phone not set for ' . $identifier);
            return false;
        }

        return true;
    }
}

