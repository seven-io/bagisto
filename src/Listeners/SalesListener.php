<?php /** @noinspection PhpUnused */

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Customer\Models\Customer;
use Webkul\Sales\Models\Shipment;

readonly class SalesListener extends AbstractListener {
    public function afterSaveShipment(Shipment $shipment): void {
        dump($shipment);
        $customer = $shipment->customer()->first();
        dump($shipment);
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterSaveShipmentText();
        if (empty($text)) {
            Log::debug('seven: text not set for sales::afterSaveShipment');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms([$customer], $smsParams);
        Log::debug('seven: sent message for sales::afterSaveShipment', $res);
    }
}

