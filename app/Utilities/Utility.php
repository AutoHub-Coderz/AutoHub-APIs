<?php

namespace App\Utilities;

class Utility
{
    public static function alphaNumericOnly($data)
    {
        $str = preg_replace("/[^a-zA-Z0-9]+/", "", $data);
        if (strlen($str) < 5) {
            return "";
        }
        return $str;
    }


    public static function nullEmptyArray($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key]  =  self::nullEmptyArray($value);
            }
            if (empty($value) && !strlen($value)) {
                $array[$key] = NULL;
            }
        }

        return $array;
    }

    public static function emptyNullArray($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key]  =  self::emptyNullArray($value);
            }
            if ($value === null) {
                $array[$key] = "";
            }
        }

        return $array;
    }

    public static function toUpperCase($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key]  =  self::toUpperCase($value);
                } else {
                    $data[$key] = strtoupper($data[$key]);
                }
            }
            return $data;
        } else {
            return strtoupper($data);
        }
    }

    public static function includeFiles($directory)
    {
        if (is_dir($directory)) {
            $scan = scandir($directory);
            unset($scan[0], $scan[1]); //unset . and ..
            foreach ($scan as $file) {
                if (is_dir($directory . "/" . $file)) {
                    self::includeFiles($directory . "/" . $file);
                } else {
                    if (strpos($file, '.php') !== false) {
                        include_once($directory . "/" . $file);
                    }
                }
            }
        }
    }

    public static function numberFormat($number)
    {
        return number_format($number, 2, '.', ',');
    }

    public static function clientIP()
    {
        return isset($_SERVER['HTTP_CLIENT_IP'])
            ? $_SERVER['HTTP_CLIENT_IP']
            : (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
                ? $_SERVER['HTTP_X_FORWARDED_FOR']
                : $_SERVER['REMOTE_ADDR']);
    }

    public static function clientUserAgent()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return null;
        }
        return $_SERVER['HTTP_USER_AGENT'];
    }




    public static function curl($array_data)
    {
        if (empty($array_data['uri'])) {
            return "No uri";
        }
        $ch = \curl_init();
        curl_setopt($ch, CURLOPT_URL, $array_data['uri']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, empty($array_data['parameters']) ? null : $array_data['parameters']);
        if (!empty($array_data['header']) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $array_data['header']);
        }

        return curl_exec($ch);
    }

    public static function escapeString($string)
    {
        $strArr = array("data" => $string);
        $jsonArr = json_encode($strArr);
        return json_decode($jsonArr['data'], true);
    }

    public static function cleanString($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key]  =  self::cleanString($value);
                } else {
                    $data[$key] = self::removeNonAscii(self::removeExtraSpace(trim($data[$key])));
                }
            }
            return $data;
        } else {
            return  self::removeNonAscii(self::removeExtraSpace(trim($data)));
        }
    }


    public static function removeNonAscii($string)
    {
        return preg_replace('/[^\r\n[:print:]]/', '', $string);
        // return  preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $string); bedt
        // return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
    }

    public static function removeExtraSpace($data)
    {
        // return  preg_replace('/\s+/', ' ', $data);
        return preg_replace('/\h+/', ' ', $data);
        // return preg_replace('/\x20+/', ' ', $data);
    }
}
