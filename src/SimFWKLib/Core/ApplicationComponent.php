<?php

namespace SimFWKLib\Core;

/**
 * Application Component class
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class ApplicationComponent
{
    /** @var SimFWKLib\Core\Application Instance of the application. */
    protected $app;

    public function __construct (Application $app)
    {
        $this->app = $app;
    }
}