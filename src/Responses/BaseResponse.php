<?php

namespace Ci4Common\Responses;

use Ci4Common\ViewModels\AbstractCollection;
use Ci4Common\ViewModels\AbstractViewModel;

class BaseResponse implements ResponseInterface
{
    /**
     * @var
     */
    protected $response;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var
     */
    protected $data;

    /**
     * @var integer
     */
    protected int $code;

    /**
     * @var array
     */
    protected array $reponseCode;

    public function __construct(string $message, int $code, $reponseCode, $data = null)
    {
         $this->response    = \Config\Services::response();
         $this->message     = $message;
         $this->data        = $data;
         $this->code        = $code;
         $this->reponseCode = $reponseCode;
    }

    /**
     * Get data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function send()
    {
        $json = [
            'Message'  => $this->message,
            'Data'     => $this->proceededData(),
            'Response' => $this->reponseCode,
        ];

        return $this->response->setStatusCode($this->code)->setJSON($json);
    }

    private function proceededData()
    {
        if ($this->data instanceof AbstractCollection) {
            return $this->data->proceed()->getElements();
        }

        if ($this->data instanceof AbstractViewModel) {
            $array = $this->data->finalArray();
            // $this->data->addResource($array);
            return $array;
        }

        return $this->data;
    }
}
