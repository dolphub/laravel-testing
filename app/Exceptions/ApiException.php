<?php

namespace App\Exceptions;

use Illuminate\Http\Exception\HttpResponseException;

class ApiException extends HttpResponseException {
    public void __construct(Response $response) {
        parent::__construct($response);
    }
}
