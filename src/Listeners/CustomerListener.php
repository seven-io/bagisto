<?php

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Seven\Bagisto\Services\Configuration;
use Seven\Bagisto\Services\Seven;
use Webkul\Customer\Models\Customer;

readonly class CustomerListener {
    public function __construct(protected Configuration $configuration, protected Seven $seven) {
    }

    /** @noinspection PhpUnused */
    public function afterRegistration(Customer $customer): void {
        $text = $this->configuration->getAfterRegistrationText();
        if (empty($text)) {
            Log::debug('seven: text not set for afterRegistration');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from');
        $res = $this->seven->sms([$customer], $text, $smsParams);
    }
}

