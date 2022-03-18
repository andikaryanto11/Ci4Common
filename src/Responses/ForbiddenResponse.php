<?php

namespace Ci4Common\Responses;

class ForbiddenResponse extends BaseResponse
{
    public function __construct(string $message, $responseCode, $data)
    {
        parent::__construct($message, 403, $responseCode, $data);
    }
}
