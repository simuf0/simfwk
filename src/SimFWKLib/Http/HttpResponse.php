<?php

namespace SimFWKLib\Http;

/**
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class HttpResponse
{
    use \SimFWKLib\Factory\Singleton;

    public function addHeader (string $heading)
    {
        header($heading);
    }

    public function redirect (string $location)
    {
        header("location: $location");
        die;
    }

    public function reload ()
    {
        $this->redirect(HttpRequest::getInstance()->uri());
    }

    public function send (string $html)
    {
        exit($html);
    }

    public function setCookie (string $name, string $value = "", int $expire = 0)
    {
        setcookie($name, $value, time() + $expire, null, null, false, true);
    }

    public function setSession (string $name, $value = null)
    {
        $_SESSION[$name] = $value;
    }
}