<?php

namespace Assets;

use SimFWKLib\Http\HttpRequest;
use SimFWKLib\Http\HttpResponse;

/**
 * This class represents the main application.
 * It performs some statements before running the application.
 * This class implements the singleton pattern.
 *
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Core extends \SimFWKLib\Core\Application
{
    /**
     * Execute the program
     */
    public function run ()
    {
        $this->loadService("env", $this->conf);
        $request = HttpRequest::getInstance()->uri();
        $this->router->insert("/controller/action", "index", "main");
        if ($this->router->exists($request)) {
            $data = $this->router->parse($request);
            $controller = $this->loadController($data['controller']);
            $view = $controller->execute($data['action'], $data['params']);
            HttpResponse::getInstance()->send($view);
        } else {
            // $this->loadService("http-error", 404);
        }
        $this->router->delete("/controller/action");
        /*
        // try {
        // }
        // catch (\Exception $e)
        // {
        //     $this->debugger->log($e);
        //     $this->debugger->display($e);
        // }
        */
    }
}