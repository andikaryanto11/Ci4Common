<?php

namespace Ci4Common\Libraries;

class HtmlLib
{
    public static function formOpen($action = '', $props = [], $method = 'POST')
    {
        $form     = '';
        $property = '';
        if (! empty($props)) {
            foreach ($props as $key => $prop) {
                $property .= "{$key} = '{$prop}'";
            }
        }

        $act = '';
        if (! empty($action)) {
            $act = "action='{$action}'";
        }

        $form  = "<form method = 'POST' {$act} {$property}>";
        $form .= csrf_field() ;
        if ($method === 'PUT') {
            $form .= "
            <input type='hidden' name='_method' value='put' />";
        }

        return $form;
    }

    public static function formOpenMultipart($action = '', $props = [], $method = 'POST')
    {
        $form     = '';
        $property = '';
        if (! empty($props)) {
            foreach ($props as $key => $prop) {
                $property .= "{$key} = '{$prop}'";
            }
        }

        $act = '';
        if (! empty($action)) {
            $act = "action='{$action}'";
        }

        $form  = "<form method = 'POST' {$act} {$property}  enctype='multipart/form-data'>";
        $form .= csrf_field();
        if ($method === 'PUT') {
            $form .= "
            <input type='hidden' name='_method' value='put' />";
        }

        return $form;
    }

    public static function formClose()
    {
        return '</form>';
    }

    public static function formInput($props = [])
    {
        $inputProp = '';
        $sesdata   = null;
        $datavalue = null;
        $checked   = '';

        if (SessionLib::get('dataform')) {
            $sesdata = SessionLib::get('dataform');
        }

        if (! empty($props)) {
            if (key_exists('name', $props) && $sesdata) {
                if (key_exists($props['name'], $sesdata)) {
                    $datavalue = $sesdata[$props['name']];
                }
            }

            if (key_exists('type', $props)) {
                if ($props['type'] === 'checkbox') {
                    if (isset($props['value'])) {
                        $checked = "checked=''";
                    }
                }
            }

            foreach ($props as $key => $val) {
                $newvalue = null;
                if ($key === 'value' && ! is_null($datavalue)) {
                    $newvalue = htmlspecialchars($datavalue, ENT_QUOTES);
                } else {
                    $newvalue = htmlspecialchars($val, ENT_QUOTES);
                }
                if (! empty($newvalue)) {
                    $inputProp .= $key . " = '{$newvalue}'";
                } else {
                    $inputProp .= ' ' . $key . ' ';
                }
            }
        }

        return "<input $checked {$inputProp}> ";
    }

    public static function formSelect($datas, $value, $name, $props = [])
    {
        $inputProp = '';
        if (! empty($props)) {
            foreach ($props as $key => $val) {
                if ($key !== 'value') {
                    if ($val) {
                        $inputProp .= $key . " = '{$val}'";
                    } else {
                        $inputProp .= ' ' . $key . ' ';
                    }
                }
            }
        }

        $select   = "<select {$inputProp}>";
        $selected = '';
        $option   = '';

        foreach ($datas as $data) {
            if (isset($props['value'])) {
                if ($props['value'] === $data->$value) {
                    $option .= "<option value = {$data->$value} selected>{$data->$name} </option> ";
                } else {
                    $option .= "<option value = {$data->$value}>{$data->$name} </option> ";
                }
            } else {
                $option .= "<option value = {$data->$value}>{$data->$name} </option> ";
            }
        }

        $select .= $option . '</select>';
        return $select;
    }

    public static function formTextArea($text = '', $props = [])
    {
        $sesdata = null;
        $value   = '';

        if (SessionLib::get('dataform')) {
            $sesdata = SessionLib::get('dataform');
        }

        if (key_exists('name', $props) && $sesdata) {
            if (key_exists($props['name'], $sesdata)) {
                $value = $sesdata[$props['name']];
            }
        } else {
            $value = $text;
        }

        $textAreaProp = '';
        if (! empty($props)) {
            foreach ($props as $key => $val) {
                if ($val) {
                    $textAreaProp .= $key . " = '{$val}'";
                } else {
                    $textAreaProp .= ' ' . $key;
                }
            }
        }

        return "<textarea {$textAreaProp}>{$value}</textarea>";
    }

    public static function formLink($text, $props = [])
    {
        $linkProp = '';
        if (! empty($props)) {
            foreach ($props as $key => $val) {
                if ($val) {
                    $linkProp .= $key . " = '{$val}'";
                } else {
                    $linkProp .= ' ' . $key;
                }
            }
        }

        return "<a {$linkProp} >{$text}</a>";
    }

    public static function formLabel($text, $props = [])
    {
        $labelProp = '';
        if (! empty($props)) {
            foreach ($props as $key => $val) {
                if ($val) {
                    $labelProp .= $key . " = '{$val}'";
                } else {
                    $labelProp .= ' ' . $key;
                }
            }
        }

        return "<label {$labelProp}>{$text}</label>";
    }
}
