<?php

namespace Biblionet;

/**
 * A helper class that provides some static functions.
 * 
 * @author Panagiotis Pantazopoulos <takispadaz@gmail.com>
 */
class Helper
{

    /**
     * Checks if a string is json
     *
     * @param string $str the input string to check
     * @return boolean
     */
    public static function isJson($str)
    {
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Checks if the script has been called through cli
     *
     * @return boolean
     */
    public static function isCli()
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * Calculates and return a percentage of completion
     *
     * @param integer $current the current iteration number
     * @param integer $total the total number of items
     * @return float the percentage
     */
    public static function getPercentage($current, $total)
    {
        return number_format((100 * $current) / $total, 2);
    }

    /**
     * Makes a comparison between two variables
     *
     * @param int|string $var1 The first of the variables to compare
     * @param int|string $var2 The second of the variables to compare
     * @param string $operator The oprator to use ==, !=, >=, <=, >, <
     * @return boolean The result of the comparison
     */
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
