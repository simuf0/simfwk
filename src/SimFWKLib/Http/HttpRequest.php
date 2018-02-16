<?php

namespace SimFWKLib\Http;

/**
 * @author Simon Cabos
 * @version 0.1.1
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
// final class HttpRequest
final class HttpRequest
{
    use \SimFWKLib\Factory\Singleton;

    public $get;
    public $post;
    public $files;
    public $cookie;
    public $server;
    public $session;

    private function __construct ()
    {
        $this->get     =& $_GET;
        $this->post    =& $_POST;
        $this->session =& $_SESSION;
        $this->files   = $_FILES;
        $this->cookie  = $_COOKIE;
        $this->server  = $_SERVER;
    }

    public static function uri () : string
    {
        return $_SERVER["REQUEST_URI"];
    }

    public function dataGet (string $key = "")
    {
        if (array_key_exists($key, $this->get)) {
            return $this->get[$key];
        } elseif ($key === "") {
            return $this->get;
        } else {
            return false;
        }
    }

    public function dataPost (string $key = "")
    {
        if (array_key_exists($key, $this->post)) {
            return $this->post[$key];
        } elseif ($key === "") {
            return $this->post;
        } else {
            return false;
        }
    }

    public function dataSession (string $key = "")
    {
        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
        } elseif ($key === "") {
            return $this->session;
        } else {
            return false;
        }
    }

    public function dataFiles (string $key = "")
    {
        if (array_key_exists($key, $this->files)) {
            return $this->files[$key];
        } elseif ($key === "") {
            return $this->files;
        } else {
            return false;
        }
    }

    public function dataCookie (string $key = "")
    {
        if (array_key_exists($key, $this->cookie)) {
            return $this->cookie[$key];
        } elseif ($key === "") {
            return $this->cookie;
        } else {
            return false;
        }
    }

    public function dataServer (string $key = "")
    {
        if (array_key_exists($key, $this->server)) {
            return $this->server[$key];
        } elseif ($key === "") {
            return $this->server;
        } else {
            return false;
        }
    }
}