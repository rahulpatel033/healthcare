<?php

namespace App\Exceptions;

class InvalidCredentialsException extends ApiExceptions {
    public function __construct()
    {
        return parent::__construct(
            message: "Please enter valid email and password",
            status: 401,
            error: "invalid_credentials"
        );
    }
}