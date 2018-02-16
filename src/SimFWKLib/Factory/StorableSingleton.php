<?php

namespace SimFWKLib\Factory;

 /**
 * Defines a storable singleton class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
trait StorableSingleton
{
    use Singleton;

    /**
     * Instanciate the class if not exists or get the stored instance if exists.
     * @param mixed[] ...$args Arguments passed to the class constructor.
     * @return mixed Return the single instance.
     */
    final public static function getInstance (...$args)
    {
        $request = \SimFWKLib\Http\HttpRequest::getInstance();
        $classname = (new \ReflectionClass(static::class))->getName();
        $storage = \SimFWKLib\Utils\Storage::getInstance();
        
        if (!$storage->contain($classname)) {
            self::$instance = new static(...$args);
            if (!$request->dataSession("storage")) {
                $_SESSION['storage'] = [];
            }
            $storage->store($classname,  self::$instance);
        } else {
            self::$instance = $storage->get($classname);
        }
        return self::$instance;
    }
}