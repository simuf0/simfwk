<?php

namespace FWKCore\Services;

final class Logger extends \FWKCore\Service
{
    use \FWKCore\Factory\Singleton;

    const ERROR   = "ERROR";
    const WARNING = "WARNING";
    const NOTICE  = "NOTICE";

    /** @var string $path Location of the log files */
    private $path;

    public function __construct (\FWKCore\Application $app, string $path)
    {
        parent::__construct($app);
        $this->path = $path;
    }

    public function log (
        string $filename,
        string $message,
        string $type = self::ERROR
    ) {
        $fh = new \FWKCore\FileHandler($this->path . DS . "$filename", "a");
        if(!empty($type)) {
            $message = "$type: $message";
        }
        $fh->write("[{$this->now()}] $message");
    }

    public function php_error (string $message, string $type = self::ERROR)
    {
        $this->log("php_error.log", $message, $type);
    }

    public function db_error (string $message, string $type = self::ERROR)
    {
        $this->log("db_error.log", $message, $type);
    }

    public function js_error (string $message, string $type = self::ERROR)
    {
        $this->log("js_error.log", $message, $type);
    }

    public function ajax_error (string $message, string $type = self::ERROR)
    {
        $this->log("ajax_error.log", $message, $type);
    }

    private function now ()
    {
        return date("Y-m-d H:i:s e");
    }
}
