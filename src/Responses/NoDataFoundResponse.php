<?php

namespace Ci4Common\Responses;

class NoDataFoundResponse extends BaseResponse
{
    public function __construct(string $message, $responseCode, $data)
    {
        parent::__construct($message, 204, $responseCode, $data);
    }
}
