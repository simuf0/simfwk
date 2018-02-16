<?php

/**
 * SimFramework - v.0.1.0
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */

session_start();

// Defining globals constants
define("ROOT", dirname(__DIR__));
define("DS", DIRECTORY_SEPARATOR);

// Defining global paths
define("PATHS", [
    'dist'    => realpath(ROOT . DS . "dist"),
    'scripts' => realpath(ROOT . DS . "scripts"),
    'src'     => realpath(ROOT . DS . "src"),
    'tests'   => realpath(ROOT . DS . "tests"),
    'views'   => realpath(ROOT . DS . "views"),
    'web'     => realpath(ROOT . DS . "web"),
]);

// Defining global uri
define("URI", [
    'fonts'   => "/resources/fonts",
    'img'     => "/resources/img",
    'scripts' => "/scripts",
    'styles'  => "/styles",
]);

define("CORE", PATHS['src'] . DS . "Core");

require_once PATHS['src'] . DS . "SimFWKLib" . DS ."Autoloader.php";
SimFWKLib\Autoloader::getInstance();
SimFWKLib\Bootloader::getInstance()->launch("core");