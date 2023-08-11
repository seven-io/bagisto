<?php

namespace Seven\Bagisto\Repositories;

use Seven\Bagisto\Models\Sms;
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
