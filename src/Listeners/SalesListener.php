<?php /** @noinspection PhpUnused */

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Sales\Models\Refund;
use Webkul\Sales\Models\Shipment;

readonly class SalesListener extends AbstractListener {
    public function afterSaveShipment(Shipment $shipment): void {
        $customer = $shipment->customer()->first();
        if (!$customer) {
            Log::debug('seven: customer not set for SalesListener::afterSaveOrder');
            return;
        }
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterSaveShipmentText();
        if (empty($text)) {
            Log::debug('seven: text not set for SalesListener::afterSaveShipment');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms([$customer], $smsParams);
        Log::debug('seven: sent message for SalesListener::afterSaveShipment', $res);
    }

    public function afterSaveRefund(Refund $refund): void {
        $order = $refund->order()->first();
        if (!$order) {
            Log::debug('seven: order not set for SalesListener::afterSaveRefund');
            return;
        }
        $customer = $this->customerRepository->findOrFail($order->customer_id);
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterSaveRefundText();
        if (empty($text)) {
            Log::debug('seven: text not set for SalesListener::afterSaveRefund');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms([$customer], $smsParams);
        Log::debug('seven: sent message for SalesListener::afterSaveRefund', $res);
    }
}

