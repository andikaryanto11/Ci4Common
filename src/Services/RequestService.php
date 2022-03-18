<?php

namespace Ci4Common\Services;

use Ci4Common\Services\BusinessProcess\CustomerService;
use App\Exceptions\EloquentException;
use Ci4Common\Libraries\RequestLib;

class RequestService implements RequestServiceInterface
{
   
    /**
     * @inheritdoc
     */
    public function getJson()
    {
        $json = RequestLib::getInstance()->getJson();
        return $json;
    }

    /**
     * @inheritdoc
     */
    public function getGet()
    {
        $json = RequestLib::getInstance()->getGet();
        return $json;
    }

    /**
     * @inheritdoc
     */
    public function getPost($index = null, $filter = null, $flags = null)
    {
        $json = RequestLib::getInstance()->getPost($index, $filter, $flags);
        return $json;
    }
}
