<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

/**
 * Always return JSON with Laravel API
 * https://hackernoon.com/always-return-json-with-laravel-api-870c46c5efb2
 */
class BaseRequest extends Request
{
    /**
     * @codeCoverageIgnore
     */
    public function expectsJson()
    {
        return true;
    }

    /**
     * @codeCoverageIgnore
     */
    public function wantsJson()
    {
        return true;
    }
}
