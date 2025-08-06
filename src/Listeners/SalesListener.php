<?php /** @noinspection PhpUnused */

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Customer\Models\Customer;
use Webkul\Sales\Models\Refund;
use Webkul\Sales\Models\Shipment;

readonly class SalesListener extends AbstractListener {
    public function afterSaveShipment(Shipment $shipment): void {
        $customer = $shipment->customer()->first();
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

    public function afterSaveRefund(Refund $refund): void {
        $order = $refund->order()->first();
        $customer = $this->customerRepository->findOrFail($order->customer_id);
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterSaveRefundText();
        if (empty($text)) {
            Log::debug('seven: text not set for sales::afterSaveRefund');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms([$customer], $smsParams);
        Log::debug('seven: sent message for sales::afterSaveRefund', $res);
    }
}

