<?php

namespace SimFWKLib\Factory;

 /**
 * Defines an instance class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
trait Instance
{
    /**
     * @var mixed Instance of the class.
     */
    private static $instance;

    /**
     * Instanciate the class.
     * @param array[] ...$args Arguments passed to the class constructor.
     * @return mixed Return the single instance.
     */
    final public static function getInstance (...$args)
    {
        return new static(...$args);
    }
}