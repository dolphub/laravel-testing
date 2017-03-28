<?php

namespace App\Exceptions;

use Illuminate\Http\Exception\HttpResponseException;

class ApiException extends HttpResponseException {
    public function __construct($data) {

    }
}
