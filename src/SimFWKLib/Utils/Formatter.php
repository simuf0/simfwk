<?php

namespace SimFWKLib\Utils;

/**
 * Formatter class
 * 
 * Performs formating methods.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Formatter
{
    final public static function toClassName (string $str) : string
    {
        $newStr = '';
        $str = trim($str, '/');

        for($i = 0; $i < strlen($str); $i++)
        {
            if(in_array($str[$i], ['-', '_', '/', '.'])) {
                $newStr .= strtoupper($str[++$i]);
            }
            else $newStr .= $str[$i];
        }
        return ucfirst($newStr);
    }

    final public static function toMethodName(string $str) : string
    {
        return lcfirst(self::toClassName($str));
    }

    final public static function toFilename(string $str, string $separator = "-") : string
    {
        $p = '/[^a-zA-Z]*([A-Z][^A-Z]*)/';
        $str = strtolower(preg_replace($p, "$separator$1", lcfirst($str)));
        return str_replace('.', $separator, trim($str, '/'));
    }

    // final public static function toURL($str, $delimiter='-')
    // {
    // 	$str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    // 	$str = preg_replace("/[^a-zA-Z0-9\/\_\|\+ \-]/", '', $str);
    // 	$str = strtolower(trim($str, '-'));
    // 	$str = preg_replace("/[\/\_\|\+ \-]+/", $delimiter, $str);
    //     return trim(filter_var($str, FILTER_SANITIZE_URL), '-');
    // }

    /*final public static function toSqlScript($str)
    {
        return str_replace(['-', '/', '_'], '.', trim($str, '/'));
    }*/

    // final public static function toTableName($str)
    // {
    //     $p = '/[^a-zA-Z]*([A-Z][^A-Z]*)/';
    //     $str = strtolower(preg_replace($p, '_$1', lcfirst($str)));
    //     return str_replace(['-', '/', '.'], '_', trim($str, '/'));
    // }

    // final public static function toHTML($str, $limit=false)
    // {
    //     if($limit && strlen($str) > $limit)
    //     {
    //         $str = substr($str, 0, $limit).'...';
    //     }
    //     return nl2br(htmlentities($str));
    // }
}