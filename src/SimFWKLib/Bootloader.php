<?php

namespace SimFWKLib;

/**
 * Bootloader class
 * 
 * This class represents the application's bootloader. 
 * It performs application boot statements. It can load the core application or
 * the saved applications stored into the files/assets folder.
 * This class is a part of the FWKCore system. 
 *
 * @author Simon Cabos
 * @version 0.1.1
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Bootloader
{
    use Factory\Singleton, Factory\Thrower;

    /**
     * Launch an application.
     * 
     * Loads an application. Loads the core application or the saved
     * applications stored into the files/assets folder, and executes it.
     *
     * @param  string $appName Name of the application.
     * @throws SimFWKLib\BootloaderException When the application is missing.
     */
    public function launch (string $appName)
    {
        $className = Utils\Formatter::toClassName($appName);
        $filename = PATHS['src'] . DS . "$className.php";
        if (!is_file($filename)) {
            $this->throws("E_MISSING_APP", $filename);
        }
        $application = "Assets\\$className";
        $application::getInstance()->run();
    }
}

/**
 * Bootloader exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class BootloaderException extends \LogicException
{
    use Factory\Instance;
    
    const E_MISSING_APP = "Failed loading application : missing file `%s`";
}
