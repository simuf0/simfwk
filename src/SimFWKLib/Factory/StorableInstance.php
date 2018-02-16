<?php

namespace SimFWKLib\Factory;

 /**
 * Defines a storable instance class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
trait StorableInstance
{
    use Instance;

    /**
     * Instanciate a new instance or return the stored instance if exists.
     * @param mixed[] ...$args Arguments passed to the class constructor.
     * @return mixed Return the single instance.
     */
    final public static function getInstance (...$args)
    {
        // $request = \SimFWKLib\Http\HttpRequest::getInstance();
        // $classname = (new \ReflectionClass(static::class))->getName();
        
        // if (!\SimFWKLib\Utils\Storage::contain($classname)) {
        //     self::$instance = new static(...$args);
        //     if (!$request->dataSession("storage")) {
        //         $_SESSION['storage'] = [];
        //     }
        //     \SimFWKLib\Utils\Storage::store($classname,  self::$instance);
        // } else {
        //     self::$instance = \SimFWKLib\Utils\Storage::get($classname);
        // }
        // return self::$instance;
    }
}