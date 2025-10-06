<?php /** @noinspection PhpUnused */

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Sales\Models\Order;

readonly class CheckoutListener extends AbstractListener {
    public function afterSaveOrder(Order $order): void {
        $customer = $order->customer()->first();
        if (!$customer) {
            Log::debug('seven: customer not set for CheckoutListener::afterSaveOrder');
            return;
        }
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterSaveOrderText();
        if (empty($text)) {
            Log::debug('seven: text not set for CheckoutListener::afterSaveOrder');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms([$customer], $smsParams);
        Log::debug('seven: sent message for CheckoutListener::afterSaveOrder', $res);
    }
}

