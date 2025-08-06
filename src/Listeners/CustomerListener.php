<?php

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Customer\Models\Customer;

readonly class CustomerListener extends AbstractListener {
    /** @noinspection PhpUnused */
    public function afterRegistration(Customer $customer): void {
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterRegistrationText();
        if (empty($text)) {
            Log::debug('seven: text not set for afterRegistration');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from');
        $res = $this->seven->sms([$customer], $text, $smsParams);
        Log::debug('seven: send message for afterRegistration', $res);
    }

    /** @noinspection PhpUnused */
    public function afterPasswordUpdate(Customer $customer): void {
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterPasswordUpdateText();
        if (empty($text)) {
            Log::debug('seven: text not set for afterPasswordUpdate');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from');
        $res = $this->seven->sms([$customer], $text, $smsParams);
        Log::debug('seven: send message for afterPasswordUpdate', $res);
    }
}

