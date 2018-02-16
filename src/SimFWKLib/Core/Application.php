<?php

namespace SimFWKLib\Core;

/**
 * Application class
 * 
 * This class represents the application. This is an abstract class and must be
 * inherited by the main class of the program. Routing operations, debugging 
 * operations and other services are handled into this class.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Application
{
    use \SimFWKLib\Factory\StorableSingleton, \SimFWKLib\Factory\Thrower;

    /** @var string Path of the application. */
    private $path;

    /** @var SimFWKLib\Core\Conf Instance of the configuration handler. */
    protected $conf;

    /** @var SimFWKLib\Core\Router Instance of the router handler. */
    protected $router;
    
    // /** @var SimFWKLib\Core\Debugger Instance of the debugger handler. */
    // protected $debugger;

    /**
     * Initializes the application instance
     *
     * Assigns the router instance, the service handler instance and the
     * debugger instance to the application instance.
     */
    private function __construct ()
    {
        $r = new \ReflectionClass($this);
        $this->name = $r->getName();
        $this->path = dirname(dirname($r->getFileName()));
        $this->conf = Conf::getInstance($this->path . DS . "config.ini");
        $this->router = Router::getInstance(
            $this->path . DS . "routes.json",
            \SimFWKLib\Http\HttpRequest::getInstance()
        );
    }

    /**
     * Load a controller
     *
     * Load a controller from its name and optionnaly by passing arguments.
     *
     * @param string $name Name of the controller.
     * @param mixed[] $args (Optional) Arguments of the controller.
     * @return FWKCore\Controllers\BackController Return the controller's instance.
     */
    final public function loadController (string $name, ...$args) : Controller
    {
        $formatter = \SimFWKLib\Utils\Formatter::class;
        $classname = $formatter::toClassName($name);
        $class = "{$this->name}\\Modules\\$classname";
        return new $class($this, ...$args);
    }

    /**
     * Load a service
     *
     * Load a service from its name and optionnaly by passing arguments.
     *
     * @param string $name Name of the service.
     * @param mixed[] $args (Optional) Arguments of the service.
     * @return FWKCore\Service Return the service's instance.
     */
    public function loadService (string $name, ...$args) : Service
    {
        $formatter = \SimFWKLib\Utils\Formatter::class;
        $classname = $formatter::toClassName($name);
        $class = "{$this->name}\\Services\\$classname";
        return new $class($this, ...$args);
    }

    // public function getPath ()
    // {
    //     return $this->path;
    // }

    /**
     * Execute the program
     *
     * Execute the program. This method must be overrided and contains running
     * declarations for the application.
     */
    abstract public function run ();
}