<?php

namespace Biblionet;

class Helper
{

    public static function isJson($str)
    {
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function isCli()
    {
        return PHP_SAPI === 'cli';
    }

    public static function getPercentage($current, $total)
    {
        return number_format((100 * $current) / $total, 2);
    }

    public static function compare($var1, $var2, $operator)
    {
        switch ($operator) {
            case "==":
                return $var1 == $var2;
            case "!=":
                return $var1 != $var2;
            case ">=":
                return $var1 >= $var2;
            case "<=":
                return $var1 <= $var2;
            case ">":
                return $var1 > $var2;
            case "<":
                return $var1 < $var2;
            default:
                return true;
        }
    }
}
