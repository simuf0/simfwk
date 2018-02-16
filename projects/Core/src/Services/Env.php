<?php

namespace Assets\Core\Services;

final class Env extends \SimFWKLib\Core\Service
{
    private $conf;

    public function __construct (\Assets\Core $app, \SimFWKLib\Core\Conf $conf)
    {
        parent::__construct($app);
        $this->conf = $conf;
        $this->setEnvironment();
    }

    /**
     * Define the environment behavior.
     * Set the behavior of the locale variables, the timezone and the errors.
     */
    private function setEnvironment ()
    {
        // Setting locale behavior
        if ($this->conf->exists("environment", "locale")) {
            setlocale(LC_ALL, $this->conf->get("environment", "locale"));
        }
        // Setting timezone behavior
        if ($this->conf->exists("environment", "timezone")) {
            date_default_timezone_set($this->conf->get("environment", "timezone"));
        }
        // Setting errors behavior
        if ($this->conf->exists("environment", "mode")) {
            if ($this->conf->get("environment", "mode") == "dev") {
                ini_set("display_errors", 1);
            } else {
                ini_set("display_errors", 0);
            }
        }
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    }
}