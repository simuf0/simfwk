<?php

namespace SimFWKLib;

require_once "Factory" . DS . "Instance.php";
require_once "Factory" . DS . "Singleton.php";
require_once "Factory" . DS . "Thrower.php";

/**
 * Autoloader class
 * 
 * This class delegates the autoload function.
 * It performs pathfinding statements to properly set the class locations.
 * It uses full-qualified namespace to establish the real path of the class.
 * This class is a part of the FWKCore system. 
 *
 * @author Simon Cabos
 * @version 0.1.1
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Autoloader
{
    use Factory\Singleton, Factory\Thrower;

    private function __construct ()
    {
        spl_autoload_register([$this, "load"]);
    }

    /**
     * Load a class.
     *
     * @param  string $classname Name of the class to load.
     * @throws FWKCore\Exceptions\AutoloaderException When the class is missing.
     */
    private function load (string $classname)
    {
        $parsed = explode("\\", $classname);
        $basename = array_slice($parsed, 0, 1)[0];
        switch ($basename) {
            case "Assets" :
                if (count($parsed) == 2) { // If asset is required
                    $path = PATHS['src'] . DS . $parsed[1];
                } elseif (count($parsed) > 2) { // If asset component is required
                    array_splice($parsed, 0, 2);
                    $path = PATHS['src'] . DS . implode(DS, $parsed);
                }
                break;
            case "SimFWKLib" : 
                $path = PATHS['src'] . DS . implode(DS, $parsed);
                break;
            default :
                return spl_autoload($classname);
        }
        $filename = $path . ".php";
        if (is_readable($filename)) {
            return require_once $filename;
        } else {
            $this->throws(
                "E_MISSING_CLASS",
                $classname,
                $filename
            );
        }
    }
}

/**
 * Autoloader exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class AutoloaderException extends \LogicException
{
    use Factory\Instance;
    
    const E_MISSING_CLASS = "Failed loading class `%s` : missing file `%s`";
}
