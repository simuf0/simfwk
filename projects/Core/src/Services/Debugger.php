<?php

namespace FWKCore;

/**
 * Debugger class
 * 
 * !Description here...
 * 
 * @author Simon Cabos
 * @version 0.1.0
 * @copyright 2018 Simon Cabos
 * @licence GPL - http://www.gnu.org/licenses/gpl-2.0.html
 */
final class Debugger extends ApplicationComponent
{
    use Factory\Singleton;

    /** @var FWKCore\Services\Logger Instance of the log service */
    private $logger;

    /** @var FWKCore\Services\Mailer Instance of the mail service */
    private $mailer;
    
    public function __construct (Application $app)
    {
        parent::__construct($app);
        $pathLogs = $this->app->getPath() . DS . "logs";
        $this->logger =$this->app->loadService("logger", $pathLogs);
        // $this->mailer = $this->app->loadService("mailer");
        // set_error_handler(function () {
        //     $this->toException(...func_get_args());
        // });
        // set_exception_handler(function ($e) {
        //     $this->display($e);
        // });
    }

    public function log (\Exception $e)
    {
        $this->logger->php_error();
        // $this->mailer->mail();
    }

    public function display ($e)
    {
        echo (
            "<pre><table style=\"width:100%\">"
            . $e->xdebug_message
            . "</table></pre>"
        );
    }

    private function toException (
        int $errno,
        string $errstr,
        string $errfile,
        int $errline,
        array $errcontext
    ) {
        throw new Exceptions\ErrorException(
            $errstr,
            0,
            $errno,
            $errfile, 
            $errline
        );
    }
}