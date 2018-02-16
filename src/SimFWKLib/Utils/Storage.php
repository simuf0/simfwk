<?php

namespace SimFWKLib\Utils;

// use FWKCore\Http\HttpRequest;
// use FWKCore\Http\HttpResponse;

/**
 * Storage class
 * 
 * Performs storage methods.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Storage
{
    use \SimFWKLib\Factory\Singleton;
    
    /**
     * @var \SimFWKLib\Core\Conf Instance of the configuration handler.
     */
    private static $conf = \SimFWKLib\Core\Conf::class;

    /**
     * @var Security Instance of the security handler.
     */
    private static $security = \SimFWKLib\Utils\Security::class;

    public static function store (string $name, $value)
    {
        $conf = self::$conf::getInstance(ROOT . DS . "config.ini");
        $security = Security::getInstance($conf);
        $value = empty($value) ? null : $security->encryptAES(
            serialize($value),
            $conf->get("encrypt", "key-storage")
        );
        if (!isset($_SESSION['storage'])) {
            $_SESSION['storage'] = [];
        }
        $_SESSION['storage'][$name] = $value;
    }

    public static function get (string $name)
    {
        $conf = self::$conf::getInstance(ROOT . DS . "config.ini");
        $security = Security::getInstance($conf);
        if (self::contain($name)) {
            if (is_string($_SESSION['storage'][$name])) {
                $session = $security->decryptAES(
                    $_SESSION['storage'][$name],
                    $conf->get("encrypt", "key-storage")
                );
                return unserialize($session);
            }
        }
        return false;
    }

    public static function contain (string $name) : bool
    {
        if (isset($_SESSION['storage']) && isset($_SESSION['storage'][$name])) {
            return true;
        }
        return false;
    }
}
