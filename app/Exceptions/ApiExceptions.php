<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Log;

abstract class ApiExceptions extends Exception {
    protected int $status;
    protected string $error;

    public function __construct(string $message = "", int $status = 0, string $error = "error")
    {
        parent::__construct($message);
        $this->status = $status;
        $this->error  = $error;
    }

    public function render($request): JsonResponse
    {
        //log error here
        Log::error($this->getMessage() . $this->error, ["request" => $request]);

        return response()->json([
            'success' => false,
            'error'   => $this->error,
            'message' => $this->getMessage(),
        ], $this->status);
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getErrorKey(): string
    {
        return $this->error;
    }
}