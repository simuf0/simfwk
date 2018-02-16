<?php

namespace SimFWKLib\Factory;

 /**
 * Defines a singleton class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
trait Singleton
{
    /** @var mixed Instance of the class. */
    private static $instance;

     /**
      * Unset the __clone method.
      */
    final private function __clone () {}

     /**
      * Unset the __construct method.
      */
    private function __construct () {}

    /**
     * Instanciate the class if not exists or get the instance if exists.
     * @param mixed[] ...$args Arguments passed to the class constructor.
     * @return mixed Return the single instance.
     */
    final public static function getInstance (...$args)
    {
        if (!isset(self::$instance)) {
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}