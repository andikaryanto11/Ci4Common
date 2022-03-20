<?php

namespace Ci4Common\Services;

use Ci4Common\Libraries\CommonLib;

class CommonService {
	public function encryptMd5($string)
    {
        return CommonLib::encryptMd5($string);
    }

    public function setIsDecimal($data)
    {
        return CommonLib::setIsDecimal($data);
    }

    public function setIsNumber($data, $default = 0)
    {
        return CommonLib::setIsNumber($data, $default);
    }

    public function setBoolean($value)
    {
        return CommonLib::setBoolean($value);
    }

    public function setCurrency($value)
    {
        return number_format($value, 0, ',', '.');
    }
}
