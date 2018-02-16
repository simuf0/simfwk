<?php

namespace SimFWKLib\Core;

/**
 * Router class
 * 
 * !Description here...
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Router
{
    use \SimFWKLib\Factory\Singleton, \SimFWKLib\Factory\Thrower;

    private $filename;

    private $request;

    private $routes;

    private function __construct (
        string $filename,
        \SimFWKLib\Http\HttpRequest $request
    ) {
        $this->filename = $filename;
        $this->request = $request;
        $this->setRoutes();
    }

    private function setRoutes ()
    {
        if(!\SimFWKLib\File\JSonFileHandler::exists($this->filename)) {
            $this->throws("E_MISSING_ROUTES_FILE", $this->filename);
        }
        $fh = \SimFWKLib\File\JSonFileHandler::getInstance($this->filename);
        if(!$routes = $fh->getContent()) {
            $this->throws("E_BAD_JSON_FILE", $this->filename);
        }
        $this->routes = $routes;
    }

    public function isCurrent ($request) : bool
    {
        $route = is_string($request) ? $this->get($request) : $request;
        if ( ($current = $this->get($this->request::uri())) // If current route exists
        && $route === $current) {
            return true;
        }
        return false;
    }

    public function parse (string $request) : array
    {
        $parsed = explode('/', trim($request, " \t\n\r\0\x0B/?&"));
        $controller = \SimFWKLib\Utils\Formatter::toClassName($parsed[0]);
        if (isset($parsed[1])) {
            $action = \SimFWKLib\Utils\Formatter::toMethodName($parsed[1]);
        }
        return [
            'request' => $request,
            'controller' => empty($parsed[0]) ? "index" : $controller,
            'action' => $action ?? "main",
            'params' => array_slice($parsed, 2),
        ];
    }

    public function exists (string $request) : bool
    {
        $parsed = explode('/', trim($request, " \t\n\r\0\x0B/?&"));
        $request = "/" . implode('/', array_slice($parsed, 0, 2));
        if (in_array($request, array_column($this->routes, "request"))) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get (string $request)
    {
        if ($this->exists($request)) {
            foreach($this->routes as $route) {
                if ($route['request'] == $request) {
                    return $route;
                }
            }
        }
    }

    public function insert (string $request, string $controller, string $action)
    {
        if ($this->exists($request)) {
            $this->throws("E_REQUEST_EXIST", "insert", $request);
        }
        $controller = \SimFWKLib\Utils\Formatter::toClassName($controller);
        $action = \SimFWKLib\Utils\Formatter::toMethodName($action);
        $this->routes[] = [
            'request' => $request,
            'controller' => $controller,
            'action' => $action,
        ];
        \SimFWKLib\File\JsonFileHandler::getInstance($this->filename, "w")
                                        ->setContent($this->routes);
    }

    public function update (string $request, string $controller, string $action)
    {
        if (!$this->exists($request)) {
            $this->throws("E_REQUEST_NOT_EXIST", "update", $request);
        }
        $controller = \SimFWKLib\Utils\Formatter::toClassName($controller);
        $action = \SimFWKLib\Utils\Formatter::toMethodName($action);
        foreach ($this->routes as $k => $route) {
            if ($route['request'] == $request) {
                $this->routes[$k] = [
                    'request' => $request,
                    'controller' => $controller,
                    'action' => $action,
                ];
                break;
            }
        }
        \SimFWKLib\File\JsonFileHandler::getInstance($this->filename, "w")
                                        ->setContent($this->routes);
    }

    public function delete (string $request)
    {
        if (!$this->exists($request)) {
            $this->throws("E_REQUEST_NOT_EXIST", "delete", $request);
        }
        foreach ($this->routes as $k => $route) {
            if ($route['request'] == $request) {
                unset($this->routes[$k]);
                break;
            }
        }
        \SimFWKLib\File\JsonFileHandler::getInstance($this->filename, "w")
                                        ->setContent($this->routes);
    }
}

/**
 * Router exception class
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
class RouterException extends \LogicException
{
    use \SimFWKLib\Factory\Instance;

    const E_MISSING_ROUTES_FILE = "Failed loading router : missing file `%s`";
    const E_BAD_JSON_FILE = "Failed loading router : error parsing json file `%s`";
    const E_REQUEST_EXIST = "Failed executing router statement `%s` : request `%s` already exists";
    const E_REQUEST_NOT_EXIST = "Failed executing router statement `%s` : request `%s` doesn't exists";
}
