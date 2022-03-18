<?php

namespace Ci4Common\Responses;

class SuccessResponse extends BaseResponse
{
    public function __construct(string $message, $responseCode, $data)
    {
        parent::__construct($message, 200, $responseCode, $data);
    }
}
