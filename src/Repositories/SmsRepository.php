<?php

namespace Sms77\Bagisto\Repositories;

use Sms77\Bagisto\Models\Sms;
use Webkul\Core\Eloquent\Repository;

class SmsRepository extends Repository {
    /**
     * Specify Model class name.
     * @return mixed
     */
    function model() {
        return Sms::class;
    }
}