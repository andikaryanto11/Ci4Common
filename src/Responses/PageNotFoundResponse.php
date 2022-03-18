<?php

namespace Ci4Common\Responses;

class PageNotFoundResponse extends BaseResponse
{
    public function __construct(string $message, $responseCode, $data)
    {
        parent::__construct($message, 404, $responseCode, $data);
    }
}
