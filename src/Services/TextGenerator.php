<?php

namespace Seven\Bagisto\Services;

use Webkul\Customer\Models\Customer;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Models\OrderAddress;

readonly class TextGenerator {
    public bool $hasPlaceholders;
    public array $matches;

    public function __construct(public string $text) {
        $this->matches = [];
        preg_match_all('{{{+[a-z]*_*[a-z]+}}}', $this->text, $this->matches);
        $this->hasPlaceholders = !empty($this->matches[0]);
    }

    public function replace(Customer|OrderAddress|Order $object): string {
        $text = $this->text;

        foreach ($this->matches[0] as $match) {
            $key = trim($match, '{}');
            $replace = '';
            $attr = $object->getAttribute($key);
            if ($attr) $replace = $attr;
            $text = str_replace($match, $replace, $text);
            $text = preg_replace('/\s+/', ' ', $text);
            $text = str_replace(' ,', ',', $text);
        }

        return $text;
    }
}
