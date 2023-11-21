<?php

namespace Seven\Bagisto\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Seven\Bagisto\Exceptions\UnprocessableEntityTypeException;
use Seven\Bagisto\Models\Sms;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Core\Models\CoreConfig;
use Webkul\Core\Repositories\CoreConfigRepository;

class Seven {
    /** @var string|null $apiKey */
    protected ?string $apiKey;

    /** @var Client $client */
    protected Client $client;

    /** @var CustomerRepository $customerRepository */
    protected CustomerRepository $customerRepository;

    /** @var CoreConfigRepository $coreConfigRepository */
    protected CoreConfigRepository $coreConfigRepository;

    /**
     * @param CustomerRepository $customerRepository
     * @param CoreConfigRepository $coreConfigRepository
     */
    public function __construct(
        CustomerRepository   $customerRepository,
        CoreConfigRepository $coreConfigRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->coreConfigRepository = $coreConfigRepository;
        $this->apiKey = self::getApiKey();
        $this->client = new Client([
            'base_uri' => 'https://gateway.seven.io/api/',
            RequestOptions::HEADERS => [
                'SentWith' => 'Bagisto',
                'X-Api-Key' => $this->apiKey,
            ],
        ]);
    }

    private function getApiKey(): ?string {
        $coreConfig = $this->coreConfigRepository->findOneByField('code',
            'seven.general.settings.api_key');

        if ($coreConfig) {
            /** @var CoreConfig $coreConfig */
            return $coreConfig->getAttribute('value');
        }

        return config('services.seven.api_key');
    }

    public function sms(Request $request): array {
        $persons = $this->getCustomers($request);

        if (empty($persons)) {
            $error = __('seven::app.no_recipients');
            $errors[] = $error;
            session()->flash('error', $error);
        } else {
            $cost = 0.0;
            $msgCount = 0;
            $receivers = 0;

            $text = $request->post('text');
            $errors = [];
            $requests = [];
            $matches = [];
            preg_match_all('{{{+[a-z]*_*[a-z]+}}}', $text, $matches);
            $hasPlaceholders = is_array($matches) && !empty($matches[0]);

            if ($hasPlaceholders) foreach ($persons as $person) {
                $pText = $text;

                foreach ($matches[0] as $match) {
                    $key = trim($match, '{}');
                    $replace = '';
                    $attr = $person->getAttribute($key);
                    if ($attr) $replace = $attr;
                    $pText = str_replace($match, $replace, $pText);
                    $pText = preg_replace('/\s+/', ' ', $pText);
                    $pText = str_replace(' ,', ',', $pText);
                }

                $requests[] = [
                    'text' => $pText,
                    'to' => $this->getCustomersNumbers($person),
                ];
            }
            else $requests[] = [
                'text' => $text,
                'to' => $this->getCustomersNumbers(...$persons),
            ];

            $smsParams = ['json' => true,];

            foreach (['from',] as $key) {
                $value = $request->post($key);
                if ($value) $smsParams[$key] = $value;
            }

            foreach (['flash', 'performance_tracking',] as $key)
                if ('on' === $request->post($key)) $smsParams[$key] = true;

            foreach ($requests as $req) {
                try {
                    $response = $this->client->post('sms',
                        [RequestOptions::JSON => array_merge($smsParams, $req)])
                        ->getBody()->getContents();
                    (new Sms)->fill(
                        array_merge($req, compact('response'), ['to' => [$req['to']]]))
                        ->save();
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

    /**
     * @param Request $request
     * @return Customer[]
     */
    protected function getCustomers(Request $request): array {
        $entityType = $request->post('entityType');
        $id = $request->post('id');

        switch ($entityType) {
            case 'customers':
                if ($id) return [$this->customerRepository->find($id)];

                /** @var Collection $collection */
                $collection = $this->customerRepository->all();
                return $collection->all();
            case 'customerGroups':
                /** @var Collection $collection */
                $collection = $this->customerRepository
                    ->findByField('customer_group_id', $id);
                return $collection->all();
            default:
                throw new UnprocessableEntityTypeException($entityType, $id);
        }
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
