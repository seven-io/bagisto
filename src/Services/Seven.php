<?php

namespace Seven\Bagisto\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerRepository;

class Seven {
    protected ?string $apiKey;
    protected Client $client;

    public function __construct(
        protected CustomerRepository   $customerRepository,
        protected Configuration $configuration
    ) {
        $this->apiKey = $this->configuration->getApiKey();
        $this->client = new Client([
            'base_uri' => 'https://gateway.seven.io/api/',
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'SentWith' => 'Bagisto',
                'X-Api-Key' => $this->apiKey,
            ],
        ]);
    }

    /**
     * @param Customer[] $customers
     * @param array $smsParams
     * @return array
     * @throws GuzzleException
     */
    public function sms(array $customers, array $smsParams): array {
        if (empty($customers)) {
            $error = __('seven::app.no_recipients');
            $errors[] = $error;
            session()->flash('error', $error);
        } else {
            $text = $smsParams['text'];
            $cost = 0.0;
            $msgCount = 0;
            $receivers = 0;

            $errors = [];
            $requests = [];
            $textGenerator = new TextGenerator($text);

            if ($textGenerator->hasPlaceholders) {
                foreach ($customers as $customer) {
                    $requests[] = [
                        'text' => $textGenerator->replace($customer),
                        'to' => $smsParams['to'] ?? $this->getCustomersNumbers($customer),
                    ];
                }
            }
            else $requests[] = [
                'text' => $text,
                'to' => $smsParams['to'] ?? $this->getCustomersNumbers(...$customers),
            ];

            foreach ($requests as $req) {
                try {
                    $response = $this->client->post('sms',
                        [RequestOptions::JSON => array_merge($smsParams, $req)])->getBody()->getContents();
                    $response = json_decode($response);

                    Log::info('seven responded to SMS dispatch.', compact('response'));

                    if (is_object($response)) {
                        $cost += (float)$response->total_price;

                        foreach ($response->messages as $message) {
                            $msgCount += $message->parts;
                            $receivers++;
                        }
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    $errors[] = $error;
                    Log::error('seven failed to send SMS.', compact('error'));
                }
            }

            session()->flash('warning',
                __('seven::app.sms_sent', compact('cost', 'msgCount', 'receivers')));
        }

        return $errors;
    }

    protected function getCustomersNumbers(...$persons): string {
        $numbers = [];

        foreach ($persons as $person) {
            $phone = $person->getAttributeValue('phone');

            if ($phone) $numbers[] = $phone;
        }

        return implode(',', array_unique($numbers));
    }
}
