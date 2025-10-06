<?php /** @noinspection PhpUnused */

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Customer\Models\Customer;

readonly class CustomerListener extends AbstractListener {
    public function afterRegistration(Customer $customer): void {
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterRegistrationText();
        if (empty($text)) {
            Log::debug('seven: text not set for CustomerListener::afterRegistration');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms([$customer], $smsParams);
        Log::debug('seven: sent message for CustomerListener::afterRegistration', $res);
    }

    /** @noinspection PhpUnused */
    public function afterPasswordUpdate(Customer $customer): void {
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterPasswordUpdateText();
        if (empty($text)) {
            Log::debug('seven: text not set for CustomerListener::afterPasswordUpdate');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms([$customer], $smsParams);
        Log::debug('seven: sent message for CustomerListener::afterPasswordUpdate', $res);
    }
}

