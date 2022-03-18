<?php

namespace Ci4Common\Libraries;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Config;

class DateLib
{
    public static function getCurrentDate($format = null)
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        if (isset($format)) {
            return $date->format($format);
        }
        return $date->format('d-m-Y');
    }

    public static function setDate($strdate = null)
    {
        if (! empty($strdate)) {
            $date = new DateTime($strdate, new DateTimeZone('Asia/Jakarta'));
        } else {
            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        }
        return $date;
    }

    public static function getDate($strdate, $add = '', $format = 'Y-m-d H:i:s')
    {
        $date = date_create($strdate);
        if ($add) {
            date_add($date, date_interval_create_from_date_string($add));
        }
        return date_format($date, $format);
    }

    public static function getFormatedDate($strdate = null, $format = null)
    {
        if ($strdate) {
            $date = new DateTime($strdate, new DateTimeZone('Asia/Jakarta'));
        } else {
            $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        }
        if (isset($format)) {
            return $date->format($format);
        }
        return $date->format('Y-m-d H:i:s');
    }

    public static function getFromFormat($strdate, $fromFormat = 'd-m-Y H:i', $format = 'Y-m-d H:i:s')
    {
        $date = DateTime::createFromFormat($fromFormat, $strdate, new DateTimeZone('Asia/Jakarta'));

        return $date->format($format);
    }
}
