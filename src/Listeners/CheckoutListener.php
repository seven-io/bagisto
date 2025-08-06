<?php /** @noinspection PhpUnused */

namespace Seven\Bagisto\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Sales\Models\Order;

readonly class CheckoutListener extends AbstractListener {
    public function afterSaveOrder(Order $order): void {
        $customer = $order->customer()->first();
        if (!$this->hasPhone($customer)) return;
        $text = $this->configuration->getAfterSaveOrderText();
        if (empty($text)) {
            Log::debug('seven: text not set for checkout::afterSaveOrder');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from');
        $res = $this->seven->sms([$customer], $text, $smsParams);
        Log::debug('seven: sent message for checkout::afterSaveOrder', $res);
    }
}

