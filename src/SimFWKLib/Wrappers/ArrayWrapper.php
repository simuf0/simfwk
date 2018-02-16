<?php

namespace SimFWKLib\Wrappers;

/**
 * Array wrapper class
 * 
 * Contains array wrapper methods.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class ArrayWrapper
{
    use \SimFWKLib\Factory\Singleton;

    final public function isAssoc (array $arr) : bool
    {
        $isAssoc = false;
        foreach (array_keys($arr) as $k) {
            if (!is_int($k)) {
                $isAssoc = true;
                break;
            }
        }
        return $isAssoc;
    }
}