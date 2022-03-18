<?php

namespace Ci4Common\Libraries;

use Exception;
use JsonSerializable;

class EloquentPagingLib
{
    private $eloquent      = '';
    private $filter        = [];
    private $page          = 1;
    private $size          = 1;
    private $customRequest = null;

    protected $output = [
        'CurrentPage' => null,
        'TotalPage'   => null,
        'Data'        => null,
        'TotalData'   => null,
        'ShowingPage' => [],
        'GetQuery'    => null,

    ];

    public function __construct($eloquent, $filter = [], $page = 1, $size = 6, $queryParams = [])
    {
        $this->eloquent              = "App\\Eloquents\\$eloquent";
        $this->filter                = $filter;
        $this->size                  = $size;
        $this->output['CurrentPage'] = (int)$page;

        $this->customRequest      = \Config\Services::request();
        $this->output['GetQuery'] = createGetParam($queryParams);

        if (! is_numeric($page)) {
            $this->page = 1;
        } else {
            $this->page = $page;
        }
    }

    private function setPaging($showedPage = 5)
    {
        $expandedPage = round($showedPage / 2, 0, PHP_ROUND_HALF_DOWN);

        $lastPage  = $this->page + $expandedPage;
        $firstPage = $lastPage - $showedPage + 1;

        if ($firstPage <= 0) {
            $firstPage = 1;
        }

        if ($this->output['TotalPage'] <= $showedPage) {
            $lastPage = $this->output['TotalPage'];
            if ($showedPage - $firstPage !== $showedPage - 1) {
                $firstPage = 1;
            }
        } else {
            if ($this->page < ($lastPage - $expandedPage)) {
                $lastPage = $showedPage;
                if ($lastPage > $this->output['TotalPage']) {
                    $lastPage = $this->output['TotalPage'];
                }
            } else {
                if ($this->page < ($lastPage - $expandedPage) || $lastPage < $showedPage) {
                    $lastPage = $showedPage;
                }
                if ($this->page >= $this->output['TotalPage'] - $expandedPage) {
                    $lastPage  = $this->output['TotalPage'];
                    $firstPage = $this->output['TotalPage'] - ($expandedPage * 2);
                }
            }
        }

        for ($i = $firstPage; $i <= $lastPage; $i++) {
            $this->output['ShowingPage'][] = $i;
        }
    }

    public function setParams()
    {
        $params               = [];
        $params['join']       = isset($this->filter['join']) ? $this->filter['join'] : null;
        $params['where']      = isset($this->filter['where']) ? $this->filter['where'] : null;
        $params['whereIn']    = isset($this->filter['whereIn']) ? $this->filter['whereIn'] : null;
        $params['orWhereIn']  = isset($this->filter['orWhereIn']) ? $this->filter['orWhereIn'] : null;
        $params['orWhere']    = isset($this->filter['orWhere']) ? $this->filter['orWhere'] : null;
        $params['whereNotIn'] = isset($this->filter['whereNotIn']) ? $this->filter['whereNotIn'] : null;
        $params['like']       = isset($this->filter['like']) ? $this->filter['like'] : null;
        $params['orLike']     = isset($this->filter['orLike']) ? $this->filter['orLike'] : null;
        $params['group']      = isset($this->filter['group']) ? $this->filter['group'] : null;

        $params['limit'] = [
            'page' => $this->page,
            'size' => $this->size,
        ];

        return $params;
    }

    public function fetch()
    {
        try {
            $params = $this->setParams();
            $result = $this->eloquent::findAll($params);

            $this->output['TotalPage'] = ceil(intval($this->allData($params)) / $this->size);
            $this->output['Data']      = $result;
            $this->output['TotalData'] = $this->allData($params);
            $this->setPaging();
        } catch (Exception $e) {
            $this->output['Error'] = $e->getMessage();
        }

        return (object)$this->output;
    }

    private function allData($filter = [])
    {
        $params = [
            'join'       => isset($filter['join']) ? $filter['join'] : null,
            'where'      => isset($filter['where']) ? $filter['where'] : null,
            'whereIn'    => isset($filter['whereIn']) ? $filter['whereIn'] : null,
            'orWhere'    => isset($filter['orWhere']) ? $filter['orWhere'] : null,
            'whereNotIn' => isset($filter['whereNotIn']) ? $filter['whereNotIn'] : null,
            'like'       => isset($filter['like']) ? $filter['like'] : null,
            'orLike'     => isset($filter['orLike']) ? $filter['orLike'] : null,
            'group'      => isset($filter['group']) ? $filter['group'] : null,
        ];
        // return null;
        return $this->eloquent::count($params);
    }
}
